<?php

// Récupérer le chemin du fichier PDF depuis l'URL
if (!isset($_GET['file']) || empty($_GET['file'])) {
    die("Aucun fichier spécifié.");
}

$filePath = $_GET['file'];

// Vérifier que le fichier existe
if (!file_exists($filePath)) {
    die("Le fichier demandé n'existe pas.");
}

// Vérifier que le fichier est un PDF
$fileInfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($fileInfo, $filePath);
finfo_close($fileInfo);

if ($mimeType !== 'application/pdf') {
    die("Le fichier n'est pas un PDF valide.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher le PDF</title>
    <!-- Utilisation de PDF.js via CDN (jsDelivr) -->
    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.11.174/build/pdf.min.js"></script>
    <!-- Tailwind CSS pour le style -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #pdf-viewer {
            width: 100%;
            height: 80vh;
            border: 1px solid #ccc;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Afficher le PDF</h1>

        <!-- Contrôles de navigation -->
        <div class="flex items-center justify-between mb-4">
            <button id="prev-page" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-all">
                Page précédente
            </button>
            <span class="text-gray-700">
                Page <span id="page-num"></span> sur <span id="page-count"></span>
            </span>
            <button id="next-page" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-all">
                Page suivante
            </button>
        </div>

        <!-- Conteneur pour le PDF -->
        <div id="pdf-viewer" class="bg-white shadow-md"></div>
    </div>

    <script>
        // Chemin du fichier PDF
        const pdfPath = "<?= htmlspecialchars($filePath) ?>";

        let currentPage = 1;
        let pdfDoc = null;

        // Charger le PDF
        pdfjsLib.getDocument(pdfPath).promise.then(pdf => {
            pdfDoc = pdf;
            document.getElementById('page-count').textContent = pdf.numPages;
            renderPage(currentPage);
        }).catch(error => {
            console.error("Erreur lors du chargement du PDF :", error);
            alert("Une erreur s'est produite lors du chargement du PDF.");
        });

        // Fonction pour afficher une page
        function renderPage(pageNum) {
            pdfDoc.getPage(pageNum).then(page => {
                const viewer = document.getElementById('pdf-viewer');
                viewer.innerHTML = ''; // Effacer le contenu précédent
                const canvas = document.createElement('canvas');
                viewer.appendChild(canvas);
                const context = canvas.getContext('2d');
                const viewport = page.getViewport({ scale: 1.5 });
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                page.render({ canvasContext: context, viewport: viewport });
                document.getElementById('page-num').textContent = pageNum;
            });
        }

        // Bouton Page précédente
        document.getElementById('prev-page').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderPage(currentPage);
            }
        });

        // Bouton Page suivante
        document.getElementById('next-page').addEventListener('click', () => {
            if (currentPage < pdfDoc.numPages) {
                currentPage++;
                renderPage(currentPage);
            }
        });
    </script>
</body>
</html>