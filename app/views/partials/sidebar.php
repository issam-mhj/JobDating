<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouCode Admin - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white p-4">
            <div class="flex items-center justify-center mb-8">
                <img src="https://imgs.search.brave.com/R5Wwep8H98CL2PUKxv3W-4j2okGfFEAlK1wZ6Swz7FE/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9hdGQt/YmxvZ2VzLnMzLnVz/LWVhc3QtMi5hbWF6/b25hd3MuY29tL3dw/LWNvbnRlbnQvdXBs/b2Fkcy8yMDIyLzA0/LzE2MTQyODM2L2Nv/b2wtcHJvZmlsZS1w/aWN0dXJlcy1mb3It/eW91dHViZS0xNy53/ZWJw" alt="YouCode Logo" class="h-8 w-8 mr-2 rounded-xl">
                <div class="text-xl font-bold">YouCode Admin</div>
            </div>
            <!-- sidebar.twig -->
            <nav>
                <ul class="space-y-2">
                    <li>
                        <a href="/Admin" class="flex items-center p-3 {{ currentUrl == '/Admin' ? 'bg-blue-600' : 'hover:bg-gray-700' }} rounded-lg">
                            <i class="fas fa-chart-line w-6"></i>
                            <span>Statistiques</span>
                        </a>
                    </li>
                    <li>
                        <a href="/Admin/Announcements" class="flex items-center p-3 {{ currentUrl == '/Admin/Announcements' ? 'bg-blue-600' : 'hover:bg-gray-700' }} rounded-lg">
                            <i class="fas fa-bullhorn w-6"></i>
                            <span>Annonces</span>
                        </a>
                    </li>
                    <li>
                        <a href="/Admin/Companies" class="flex items-center p-3 {{ currentUrl == '/Admin/Companies' ? 'bg-blue-600' : 'hover:bg-gray-700' }} rounded-lg">
                            <i class="fas fa-building w-6"></i>
                            <span>Entreprises</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>