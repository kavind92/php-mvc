<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome</title>
        <link rel="stylesheet" type="text/css" href="<?php echo file_access("app/public-files/css/WelcomePage_stylesheet.css"); ?>"/>
    </head>
    <body>
        <h1>MVC<small> version {MVC_SYSTEM_VERSION}</small></h1>

        <h1>Welcome .. !!</h1>

        <h3>if you see this page MVC installation is success !!!</h3>

        <p>The controller for this page is here:</p>

        <div class="code">app/controllers/welcome.php</div>

        <p>The view file for this page is here:</p>

        <div class="code">app/views/welcome.php</div>

        Let's get started,<a href="user-guide/index.html">read documentation</a> 

        <div id="bottom	">
            This <a href="#/">MVC</a> is licensed under the GNU <a rel="license" href="http://www.gnu.org/licenses/lgpl.html">LGPL</a> license.
            <br />
            <span style="font-size: 0.8em">This page was rendered in {MVC_SYSTEM_TIMER} seconds.</span>
        </div>
        
        <div>
            <h3>Test</h3>
            <?php echo base_url(); ?>
        </div>
    </body>
</html>
