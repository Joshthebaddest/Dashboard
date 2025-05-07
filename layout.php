<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My App</title>
        <link rel="stylesheet" href="../public/css/style.css">
        <!-- Development version -->
        <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>


    <style>
        /* table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #DDD;
        } */

        table {
            border-collapse: collapse;
            width: 100%;
        }
        tbody tr:hover {background-color: #D6EEEE;}
        .container{
            width: 100%;
            height: 300px;
            overflow: auto;
        }
        .btn{
            height: fit-content;
            font-size: 12px;
            color: white;
            border-radius: 5px;
            margin: 5px 10px;
        }
    </style>
    </head>

    <body class="">
        <div class="flex h-screen bg-gray-100">
            <!-- sidebar -->
            <?php include __DIR__ .'/template/sidebar.php'; ?>
            <!-- sidebar end -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Header -->
                <?php include __DIR__ .'/template/header.php'; ?>
                <!-- Header end -->
                <div class="p-5 px-10 text-center w-full overflow-auto relative">
                    <div class="text-left pb-10 px-10"> 
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
        </div>

        <script src="../public/js/script.js"></script>
        <script>
            lucide.createIcons();
        </script>
    </body>
</html>