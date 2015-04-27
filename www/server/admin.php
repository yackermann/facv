<?php
    error_reporting(E_ALL); 
    ini_set( 'display_errors','1');
    include __DIR__.'/includes/session.php';
    include __DIR__.'/includes/sql_requests.php';
    $SQLGet = new SQLRequests\Get();

    $templates = array(
        'table' => '<div class="row"><div class="large-12 columns"><table role="grid">%content%</table></div></div>',
        'users' => '<thead><tr><th width="600">Username</th><th width="200">Edit</th><th width="200">Delete</th></tr></thead><tbody>%tableitems%</tbody>',
        'adverts' => '<thead><tr><th width="125">Title</th><th width="125">Description</th><th width="125">End date</th><th width="125">Category</th><th width="125">Email</th><th width="125">Phone</th><th width="125"></th><th width="125"></th></tr></thead><tbody>%tableitems%</tbody>'
    );
    $content = '';
    $cdir = '';

    if($_GET && isset($_GET['open']) && in_array($_GET['open'], ['users', 'adverts'])){
        if( $_GET['open'] === 'users' ){
            $cdir = 'Users';

            $content = str_replace( '%content%' , $templates['users'] , $templates['table'] );

            foreach ($SQLGet -> users() as $value) {
                extract($value);
                $item = "<tr>
                            <td>$username</td>
                            <td><a href=\"#$id\" class=\"medium expand success button\">Edit</a></td>
                            <td><a href=\"#$id\" class=\"medium expand alert button\">Delete</a></td>
                        </tr>%tableitems%";
                $content = str_replace( '%tableitems%' , $item , $content );
            }

            $content =  str_replace( '%tableitems%' , '' , $content );

        }else if( $_GET['open'] === 'adverts' ){

            $cdir = 'Adverts';

            $content = str_replace( '%content%' , $templates['adverts'] , $templates['table'] );

            foreach ($SQLGet -> adverts() as $value) {
                extract($value);
                $item = "<tr>
                            <td>$title</td>
                            <td>$text</td>
                            <td>$endDate</td>
                            <td>$categoryId</td>
                            <td>$email</td>
                            <td>$phone</td>
                            <td><a href=\"#$id\" class=\"medium expand success button\">Edit</a></td>
                            <td><a href=\"#$id\" class=\"medium expand alert button\">Delete</a></td>
                        </tr>%tableitems%";
                $content = str_replace( '%tableitems%' , $item , $content );
            }

            $content =  str_replace( '%tableitems%' , '' , $content );
        }

    }else{
        $content = '<div class="row"><div class="large-12 columns"><h2 style="text-align: center;"><a href="?open=users">Users</a> || <a href="?open=adverts">Adverts</a></h2></div></div>';
    }
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Admin<?php if($cdir !== '') echo ' | '.$cdir; ?></title>
        <link rel="stylesheet" href="/css/foundation.css" />
        <script src="/js/vendor/modernizr.js"></script>
        <style>
            table{
                table-layout:fixed;
                overflow: hidden;
                white-space: nowrap;
            }
        </style>
    </head>
    <body>
        <div class="row">
            <div class="large-12 columns">
                <a href="admin"><h1>Admin</h1></a>
            </div>
        </div>

        <?php echo $content; ?>

        <footer class="row">
            <div class="large-12 columns">
                <hr>
                <div class="row">
                    <div class="large-6 columns">
                        <p>© Copyright no one at all. Go to town.</p>
                    </div>
                    <div class="large-6 columns">
                        <ul class="inline-list right">
                            <li><a href="?open=users">Users</a></li>
                            <li><a href="?open=adverts">Adverts</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <script src="/js/vendor/jquery.js"></script>
        <script src="/js/foundation.min.js"></script>
        <script>
            $(document).foundation();
        </script>
    </body>
</html>
