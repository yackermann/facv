<?php
    require __DIR__.'/includes/session.php';
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Admin</title>
        <link rel="stylesheet" href="/css/foundation.css" />
        <link rel="stylesheet" href="/css/custom.css" />
        <link rel="stylesheet" href="/css/foundation-datepicker.css" />
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
                <a href="admin"><h1 class="translateMe" data-tid="admin">Admin</h1></a>
            </div>
        </div>

        <div class="row">
            <div class="tabs-content">

                <section role="tabpanel" aria-hidden="false" class="content active" id="main">
                    <h2 style="text-align: center;">
                        <a href="#users" class="translateMe" data-tid="users">Users</a> || <a href="#adb" class="translateMe" data-tid="adverts">Adverts</a>
                    </h2>
                </section>

                <section role="tabpanel" aria-hidden="false" class="content" id="adb">
                    <div class="large-12 columns">
                        <input type="text" class="translateMe" data-tid="search" name="search" placeholder="Search">
                    </div>
                    <div class="large-12 columns">
                        <table role="grid">
                            <thead>
                                <tr>
                                    <th width="125" class="translateMe" data-tid="title">Title</th>
                                    <th width="125" class="translateMe" data-tid="endDate">End date</th>
                                    <th width="125" class="translateMe" data-tid="email">Email</th>
                                    <th width="125" class="translateMe" data-tid="phone">Phone</th>
                                    <th width="125"></th>
                                    <th width="125"></th>
                                    <th width="125"><a class="small expand button addAdv">+</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </section>

                <section role="tabpanel" aria-hidden="false" class="content" id="users">
                    <div class="large-12 columns">
                        <table role="grid">
                            <thead>
                                <tr>
                                    <th width="600" class="translateMe" data-tid="username">Username</th>
                                    <th width="200"></th>
                                    <th width="200"><a class="small expand success button addUser">+</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>
        </div>
        

        <footer class="row">
            <div class="large-12 columns">
                <hr>
                <div class="row">
                    <div class="large-6 columns">
                        <p>&copy; <span class="translateMe" data-tid="footer">Copyright no one at all. Go to town.</span></p>
                    </div>
                    <div class="large-6 columns">
                        <ul class="inline-list right">
                            <li><a href="/server/login?logout" class="translateMe" data-tid="logout">Logout</a></li>
                            <li>|</li>
                            <li><a href="/" class="translateMe" data-tid="backToMain">Main Page</a></li>
                            <li><a href="#users" class="translateMe" data-tid="users">Users</a></li>
                            <li><a href="#adb" class="translateMe" data-tid="adverts">Adverts</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <input type="file" id="files" class="dropzone" data-eval="false" style="opacity:0"> 
        <div id="newAdvert" class="reveal-modal large" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
            <fieldset>
                <legend class="translateMe" data-tid="newAdvert">New advert</legend>
                <div id="drop_zone" class="large-5 columns dropzone parent">
                    <div class="dropzone centered">
                        <span class="dropzone text translateMe" data-tid="dropzone">
                            Drop your files here
                        </span>
                    </div>
                    
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

         <!--Modal LOGIN form-->
        <div id="addUser" class="reveal-modal medium" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
            <fieldset>
                <legend class="translateMe" data-tid="newUser">Login</legend>
                <div class="row collapse">
                    <div class="small-9 columns">
                        <input type="text" name="username">
                    </div>
                    <div class="small-3 columns">
                        <span class="postfix translateMe" data-tid="username">Username</span>
                    </div>
                </div>
                <div class="row collapse">
                    <div class="small-9 columns">
                        <input class="pass" type="password" name="password">
                    </div>
                    <div class="small-3 columns">
                        <span class="postfix translateMe" data-tid="password">Password</span>
                    </div>
                </div>
                <div class="row collapse">
                    <div class="small-9 columns">
                        <input class="pass" type="password" name="passwordRe">
                    </div>
                    <div class="small-3 columns">
                        <span class="postfix translateMe" data-tid="rePassword">Repeat password</span>
                    </div>
                </div>
                <a tabindex="0" class="register button expand success translateMe" data-tid="register">Register</a>
                <a class="close-reveal-modal" aria-label="Close">&#215;</a>
            </fieldset>
        </div>

         <!--Modal LOGIN form-->
        <div id="changePass" class="reveal-modal medium" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
            <fieldset>
                <legend class="translateMe" data-tid="changePass">Change Password</legend>
                <div class="row collapse">
                    <div class="small-9 columns">
                        <input class="pass" type="password" name="DeltaPassword">
                    </div>
                    <div class="small-3 columns">
                        <span class="postfix translateMe" data-tid="password">Password</span>
                    </div>
                </div>
                <div class="row collapse">
                    <div class="small-9 columns">
                        <input class="pass" type="password" name="DeltaPasswordRe">
                    </div>
                    <div class="small-3 columns">
                        <span class="postfix translateMe" data-tid="rePassword">Repeat password</span>
                    </div>
                </div>
                <a tabindex="0" class="submitChangePass button expand success translateMe" data-tid="update">Update</a>
                <a class="close-reveal-modal" aria-label="Close">&#215;</a>
            </fieldset>
        </div>

        <!--DELETE ADVERT CONFIRMATION.-->
        <div class="reveal-modal confirm adv tiny" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
            <div class="large-6 columns translateMe" data-tid="areYouSureAdv"></div>
            <div class="large-3 columns">
                <a href="#" class="medium expand success button submitNo adv translateMe" data-tid="no">NO</a>
            </div>
            <div class="large-3 columns">                            
                <a href="#" class="medium expand alert button submitYes adv translateMe" data-tid="yes">Yes</a>
            </div>
        </div>

        <!--DELETE USER CONFIRMATION.-->
        <div class="reveal-modal confirm user tiny" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
            <div class="large-6 columns translateMe" data-tid="areYouSureUser"></div>
            <div class="large-3 columns">
                <a href="#" class="medium expand success button submitNo user translateMe" data-tid="no">NO</a>
            </div>
            <div class="large-3 columns">                            
                <a href="#" class="medium expand alert button submitYes user translateMe" data-tid="yes">Yes</a>
            </div>
        </div>

        <div class="alert-div"></div>

        <script type="text/javascript" src="/js/vendor/jquery.js"></script>
        <script type="text/javascript" src="/js/foundation.min.js"></script>
        <script type="text/javascript" src="/js/foundation-datepicker.js"></script>
        <script type="text/javascript" src="/js/admin.jquery.js"></script>
        <script type="text/javascript" src="/js/sha512.js"></script>
        <script>
            $(document).ready(function(){
                $(document).foundation({
                    reveal: {
                        close_on_background_click: false
                    }
                });
                $(document).admin();

                if(window.location.hash && window.location.hash !== '#'){
                    $('.tabs-content > section.content').removeClass('active')
                    $(window.location.hash).addClass('active')
                }else{
                    $('.tabs-content > section.content').removeClass('active')
                    $('#main').addClass('active')
                }

                $(window).on('hashchange', function() {
                    if(window.location.hash !== '#'){
                        $('.tabs-content > section.content').removeClass('active')
                        $(window.location.hash).addClass('active')
                    }else{
                        $('.tabs-content > section.content').removeClass('active')
                        $('#main').addClass('active')
                    }
                });
            })
        </script>
    </body>
</html>
