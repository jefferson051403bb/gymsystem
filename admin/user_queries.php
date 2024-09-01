<?php
    require('inc/essentials.php');
    require('inc/db_config.php');
    adminLogin();

    if(isset($_GET['seen']))
    {
        $frm_data = filteration($_GET);

        if($frm_data['seen']=='all'){
            $q = "UPDATE `user_queries` SET `seen`=?";
            $values = [1];
            if(update($q,$values,'i')){
                alert('success','Marked all as read!');
            }
            else{
                alert('error','Operation failed!');
            }
        }
        else
        {
            $q = "UPDATE `user_queries` SET `seen`=? WHERE `q_id`=?";
            $values = [1,$frm_data['seen']];
            if(update($q,$values,'ii')){
                alert('success','Marked as read!');
            }
            else{
                alert('error','Operation failed!');
            }
        }
    }

    if(isset($_GET['del']))
    {
        $frm_data = filteration($_GET);

        if($frm_data['del']=='all'){
            $q = "DELETE FROM `user_queries`";
            if(mysqli_query($con,$q)){
                alert('success','All Data Deleted!');
            }
            else{
                alert('error','Operation failed!');
            }
        }
        else
        {
            $q = "DELETE FROM `user_queries` WHERE `q_id`=?";
            $values = [$frm_data['del']];
            if(delete($q,$values,'i')){
                alert('success','Data Deleted!');
            }
            else{
                alert('error','Operation failed!');
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER QUERIES</title>

    <?php require('inc/links.php');?>

    <style>

        th{
            background-color: #40534C !important;
        }

    </style>

</head>
<body class="bg-light">
    
<?php require('inc/header.php');?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
              <h3 class="mb-4"style="text-align:center;">USER QUERIES</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm">
                                <i class="bi bi-check-all"></i> Mark all as read
                            </a>
                            <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm">
                                <i class="bi bi-trash"></i> Delete all
                            </a>

                        </div>

                        <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-white" style="overflow-y: hidden;">
                                        <th scope="col">#</th>
                                        <th scope="col" width="10%">Name</th>
                                        <th scope="col" width="10%">Email</th>
                                        <th scope="col" width="10%">Subject</th>
                                        <th scope="col" width="45%">Message</th>
                                        <th scope="col" width="10%">Date</th>
                                        <th scope="col" width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                        <?php 
                        $q = "SELECT * FROM `user_queries` ORDER BY `q_id` DESC";
                        $data = mysqli_query($con, $q);
                        $i = 1;

                        while ($row = mysqli_fetch_assoc($data)) {
                        $seen = '';
                        if ($row['seen'] != 1) {
                        $seen = "<a href='?seen=$row[q_id]' class='btn btn-sm rounded-pill btn-primary'><i class='bi bi-eye-fill'></i></a> ";
                        }
                        // Construct the mailto URL with recipient's email
                        $mailtoUrl = "https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=$row[email]";
                        $seen .= "<a href='$mailtoUrl' class='btn btn-sm rounded-pill btn-success'><i class='bi bi-reply'></i></a> ";
                        $seen .= "<a href='?del=$row[q_id]' class='btn btn-sm rounded-pill btn-danger'><i class='bi bi-trash'></i></a>";

                        echo "<tr>
                        <td>$i</td>
                        <td>$row[name]</td>
                        <td>$row[email]</td>
                        <td>$row[subject]</td>
                        <td>$row[message]</td>
                        <td>$row[date]</td>
                        <td>$seen</td>
                        </tr>";
                        $i++;
                        }
                        ?>



                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require('inc/scripts.php');?>

    <script src="scripts/carousel.js"></script>

</body>
</html>