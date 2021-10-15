<?php
include 'classes/dbh.class.php';
include 'classes/subs.class.php';
include 'classes/subscontroller.class.php';
include 'classes/subsview.class.php';

//there are probably better ways to do this
session_start();
if(isset($_GET['sort']))
    $_SESSION['sort'] = $_GET['sort'];
if(isset($_GET['filter']))
    $_SESSION['filter'] = $_GET['filter'];
if(isset($_GET['search']))
    $_SESSION['search'] = $_GET['search'];
if (isset($_GET['delete'])){
    $cont = new SubsController();
    $cont->deleteSubscription($_GET['delete']);
}


$view = new SubsView();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pineapple subscriptions</title>
</head>
<body>
    <?php echo $view->showUniqueProviders();?>
    <form method="GET" action="/subscriptions.php" style="margin-top: 1rem; margin-right: 1rem;">
        <input type="text" name="search">
        <input type="submit" value="Search">
    </form>
    <?php if(isset($_SESSION['search']) && ($_SESSION['search'] !== '')): ?>
        <div>Search results for: <?php echo $_SESSION['search'] ?></div>
    <?php endif?>
    <table>
        <thead>
            <tr>
                <th><a href="/subscriptions.php?sort=name">E-mail</a></th>
                <th><a href="/subscriptions.php?sort=date">Date</a></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(isset($_SESSION['sort']) && ($_SESSION['sort'] === 'name'))
                $sortBy = 'name';
            else
                $sortBy = 'date';
            if(isset($_SESSION['filter']))
                $provider = $_SESSION['filter'];
            else
                $provider = '';
            if(isset($_SESSION['search']))
                $searchTerm = $_SESSION['search'];
            else
                $searchTerm = '';
            
            echo $view->showSubscriptions($sortBy, $provider, $searchTerm);
            ?>
        </tbody>
    </table>
</body>
</html>