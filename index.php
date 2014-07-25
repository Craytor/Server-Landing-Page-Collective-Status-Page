<?php
    session_start();
    $sites = array('acadia.team-radiant.com', 'bamboo.team-radiant.com', 'cosmos.team-radiant.com', 'droplet.team-radiant.com');

    foreach($sites as $site) {
        $_SESSION[$site] = json_decode(file_get_contents("http://" . $site . "/?json=1"));
    }


?>
<html>
    <head>
        <title>Status</title>
        <link rel="stylesheet" href="css/main.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/jqknob.js"></script>
        <script>
            $(document).ready(function() {
                // Show ring charts
                $("#k-disk, #k-memory, #k-swap, #k-cpu").knob({
                    readOnly: true,
                    width: 40,
                    height: 40,
                    thickness: 0.2,
                    fontWeight: 'normal',
                    bgColor: 'rgba(127,127,127,0.15)', // 50% grey with a low opacity, should work with most backgrounds
                    fgColor: '#ccc'
                });
            });
        </script>
    </head>
    <body>
        <section class="header">
            <h1>Server Status Page</h1>
        </section>
        <section class="list">
            <?php foreach($sites as $site) { ?>

            <div class="status" style="background-image: url('<?php echo $_SESSION[$site]->{'img'}; ?>'); background-size: 100%; background-position: center center;" >
                <div class="grey">
                    <div class="left">
                        <h4><?php echo $site; ?></h4>
                        <span><?php echo $_SESSION[$site]->{'ip'}; ?></span>
                    </div>
                    <div class="right">
                        Uptime: <span id="uptime"><?php echo $_SESSION[$site]->{'uptime'}; ?></span>&emsp;
                        Disk usage: <input id="k-disk" value="<?php echo $_SESSION[$site]->{'disk'}; ?>">&emsp;
                        Memory: <input id="k-memory" value="<?php echo $_SESSION[$site]->{'memory'}; ?>">&emsp;
                        <?php if($_SESSION[$site]->{'swap_total'} !== "0") { ?>
                            Swap: <input id="k-swap" value="<?php echo $_SESSION[$site]->{'swap'}; ?>">&emsp;
                        <?php } ?>
                        CPU: <input id="k-cpu" value="<?php echo $_SESSION[$site]->{'cpu'}; ?>">&emsp;
                    </div>
                </div>
            </div>

            <?php } ?>


        </section>
    </body>
</html>