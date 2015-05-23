<?php
    error_reporting(E_ALL); 
    ini_set( 'display_errors','1');
    require __DIR__.'/includes/session.php';
    include __DIR__.'/includes/sql_requests.php';
    $SQLGet = new SQLRequests\Get();

    $templates = array(
        'table' => '<div class="row">
                        <div class="large-12 columns">
                            <table role="grid">%content%</table>
                        </div>
                    </div>',

        'users' => '<thead>
                        <tr>
                            <th width="600" class="translateMe" data-tid="username">Username</th>
                            <th width="200" class="translateMe" data-tid="edit">Edit</th>
                            <th width="200" class="translateMe" data-tid="delete">Delete</th>
                        </tr>
                    </thead>
                    <tbody>%tableitems%</tbody>',

        'adverts' => '<thead>
                        <tr>
                            <th width="125" class="translateMe" data-tid="title">Title</th>
                            <th width="125" class="translateMe" data-tid="description">Description</th>
                            <th width="125" class="translateMe" data-tid="endDate">End date</th>
                            <th width="125" class="translateMe" data-tid="category">Category</th>
                            <th width="125" class="translateMe" data-tid="email">Email</th>
                            <th width="125" class="translateMe" data-tid="phone">Phone</th>
                            <th width="125"></th>
                            <th width="125"></th>
                        </tr>
                    </thead>
                    <tbody>%tableitems%</tbody>'
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
                            <td><a href=\"#$id\" class=\"medium expand success button translateMe\" data-tid=\"edit\">Edit</a></td>
                            <td><a href=\"#$id\" class=\"medium expand alert button translateMe\" data-tid=\"delete\">Delete</a></td>
                        </tr>%tableitems%";
                $content = str_replace( '%tableitems%' , $item , $content );
            }

            $content =  str_replace( '%tableitems%' , '' , $content );

        }else if( $_GET['open'] === 'adverts' ){

            $cdir = 'Adverts';

            $content = str_replace( '%content%' , $templates['adverts'] , $templates['table'] );

            foreach ($SQLGet -> adverts() as $value) {
                extract($value);
                $item = "<tr id=\"$id\">
                            <td>$title</td>
                            <td>$text</td>
                            <td>$endDate</td>
                            <td>$categoryId</td>
                            <td>$email</td>
                            <td>$phone</td>
                            <td><a href=\"#$id\" class=\"medium expand success button translateMe\" data-id=\"$id\" data-tid=\"edit\">Edit</a></td>
                            <td><a href=\"#$id\" class=\"medium expand alert button deleteBtn translateMe\" data-id=\"$id\" data-tid=\"delete\">Delete</a></td>
                        </tr>%tableitems%";
                $content = str_replace( '%tableitems%' , $item , $content );
            }

            $content =  str_replace( '%tableitems%' , '' , $content );
        }

    }else{
        $content = '<div class="row"><div class="large-12 columns"><h2 style="text-align: center;"><a href="?open=users" class="translateMe" data-tid="users">Users</a> || <a href="?open=adverts" class="translateMe" data-tid="adverts">Adverts</a></h2></div></div>';
    }
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Admin<?php if($cdir !== '') echo ' | '.$cdir; ?></title>
        <link rel="stylesheet" href="/css/foundation.css" />
        <link rel="stylesheet" href="/css/custom.css" />
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
                            <li><a href="/" class="translateMe" data-tid="backToMain">Main Page</a></li>
                            <li><a href="?open=users" class="translateMe" data-tid="users">Users</a></li>
                            <li><a href="?open=adverts" class="translateMe" data-tid="adverts">Adverts</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <div id="newAdvert" class="reveal-modal large" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
            <fieldset>
                <legend class="translateMe" data-tid="newAdvert">New advert</legend>
                <div class="large-5 columns dropzone parent">
                    <div id="drop_zone" class="dropzone centered">
                        <span class="dropzone text translateMe" data-tid="dropzone">
                            Drop your files here
                        </span>
                    </div>
                    <input type="file" id="files" class="dropzone" data-eval="false" style="opacity:0"> 
                </div>
                <div class="large-7 columns">

                    <div class="large-3 columns tr translateMe" data-tid="title">Title</div>
                    <div class="large-9 columns">
                        <input type="text" tabindex="0" autocomplete="off" name="Title"  data-type="title" data-sid="title">
                    </div>

                    <div class="large-3 columns tr translateMe" data-tid="description">Description</div>
                    <div class="large-9 columns">
                        <textarea tabindex="0" data-type="text" name="Description" data-sid="text"></textarea>
                    </div>

                    <div class="large-3 columns tr translateMe" data-tid="endDate">End Date</div>
                    <div class="large-9 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-9 columns">
                                <input type="text" tabindex="0" class="endDatePicker" autocomplete="off" name="End Date" data-type="date" data-sid="endDate" readonly>
                            </div>
                            <div class="small-3 columns">
                                <span class="postfix translateMe" data-tid="date">Date</span>
                            </div>
                        </div>
                    </div>

                    <div class="large-3 columns tr translateMe" data-tid="category">Category</div>
                    <div class="large-9 columns">
                        <select data-type="category" name="Category" data-sid="categoryId">
                            <option></option>
                        </select>
                    </div>

                    <div class="large-3 columns tr translateMe" data-tid="email">Email</div>
                    <div class="large-9 columns">
                        <input type="text" tabindex="0" autocomplete="off" name="Email" data-type="email" data-sid="email">
                    </div>

                    <div class="large-3 columns tr translateMe translateMe" data-tid="phone">Phone</div>
                    <div class="large-9 columns">
                        <input type="text" tabindex="0" autocomplete="off" name="Number" data-type="number" data-sid="phone">
                    </div>

                    <div class="large-3 columns tr"></div>
                    <div class="large-9 columns">
                        <a href="#" tabindex="0" class="sbmt button expand success translateMe" data-tid="submit">Submit</a>
                    </div>
                </div>
                <a class="close-reveal-modal" aria-label="Close">&#215;</a>
            </fieldset>
        </div>

        <!--DELETE CONFIRMATION.-->
        <div id="confirm" class="reveal-modal confirmDelete tiny" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
            <div class="large-6 columns translateMe" data-tid="areYouSure"></div>
            <div class="large-3 columns">
                <a href="#" class="medium expand success button submitNo translateMe" data-tid="no">NO</a>
            </div>
            <div class="large-3 columns">                            
                <a href="#" class="medium expand alert button CdeleteBtn submitYes translateMe" data-tid="yes">Yes</a>
            </div>
        </div>
             


        <div class="alert-div"></div>

        <script type="text/javascript" src="/js/vendor/jquery.js"></script>
        <script type="text/javascript" src="/js/foundation.min.js"></script>
        <script type="text/javascript" src="/js/foundation-datepicker.js"></script>
        <script type="text/javascript" src="/js/admin.jquery.js"></script>

        <script>
            $(document).foundation();
            $('.tabs-content').admin();
        </script>
    </body>
</html>
