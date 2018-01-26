<?


require 'config.php';

if ( $_SERVER['REQUEST_URI'] == '/') {
    $page = "home";
    $module = "home";
}
else {
        $URL_Path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $URL_Parts = explode('/', trim($URL_Path, ' /'));
        $page = array_shift($URL_Parts);
        $module = array_shift($URL_Parts);


        if (!empty($module)) {
        $Param = array();
        for ($i = 0; $i < count($URL_Parts); $i++) {
        $Param[$URL_Parts[$i]] = $URL_Parts[++$i];
        }
        /*if ( !preg_match('/^[A-z0-9]{1,15}$/', $module) ) exit('error url');*/
        }
    /*if ( !preg_match('/^[A-z0-9]{2,15}$/', $page) ) exit('error url');*/
}

//$CONNECT = mysql_connect($connect_ip,$connect_user,$connect_pass) or die(mysql_error());
// mysql_select_db($connect_db) or die(mysql_error());

session_start();

if ($_SESSION['id']) {
    $_SESSION['logged'] = 'TRUE';
}
else $_SESSION['logged'] = 'FALSE';

if ( file_exists('pages/'.$page.'.php') ) include 'pages/'.$page.'.php';
else if ( $_SESSION['admin'] and file_exists('admin/'.$page.'.php') ) include 'admin/'.$page.'.php';
else if ( $_SERVER['REQUEST_URI'] == '/') include 'pages/index.php';
else include 'error/page-404.php';

//Отправка сообщений ajax
function message($text) {
    exit ('{"message" : "'.$text.'"}');
}
//Редирект
function go( $url ) {
    exit ('{"go" : "'.$url.'"}');
}
//Очистка формы
function cform() {
    exit ('{"select" : ":input"}');
}
//Рандом строка
function random_str( $num = 30 ) {
    return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $num);
}
//Отправить динамическое сообщение
function MessageSend($p1, $p2, $p3 = '', $p4 = 1) {
    if ($p1 == 1) $p1 = 'Ошибка';
    else if ($p1 == 2) $p1 = 'Подсказка';
    else if ($p1 == 3) $p1 = 'Информация';
    $_SESSION['message'] = '<div class="MessageBlock"><b>'.$p1.'</b>: '.$p2.'</div>';
    if ($p4) {
    Location($p3);
    }
}
//Показать динамические сообщения
function MessageShow() {
if ($_SESSION['message'])$Message = $_SESSION['message'];
echo $Message;
unset($_SESSION['message']);
}
//Постраничная навигация
function PageSelector($p1, $p2, $p3, $p4 = 5) {
/*
$p1 - URL (Например: /news/main/page)
$p2 - Текущая страница (из $Param['page'])
$p3 - Кол-во новостей
$p4 - Кол-во записей на странице
*/
$num = 5;
//общее число страниц
$total = intval((($p3[0] - 1) / $p4) + 1); 
/*echo "Всего страниц";
echo $total; 
echo "Мы на странице";
echo $p2;*/
if($p2 > $total OR $p2 < 0) not_found();
if($p3 > $total) $page = $total;
$Page = ceil($p3[0] / $p4); //делим кол-во новостей на кол-во записей на странице.
    if ($Page > 1) { //А нужен ли переключатель?
        echo '<div class="col-xs-12">
                <div class="navigator">';
            if ($p2 > 2) {
                echo '<a href="'.$p1.'1" class="hidden-xs"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>';
            }
            if ($p2 > 1) {
                echo '<a href="'.$p1.($p2 - 1).'"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            }
            for($i = ($p2 - 1); $i < ($Page + 1); $i++) {
                if ($i > 0 and $i <= ($p2 + 1)) {
                    if ($p2 == $i) $Swch = 'active';
                else $Swch = 'SwchItem';
                echo '<a class="'.$Swch.'" href="'.$p1.$i.'">'.$i.'</a>';
                }
            }
            if ($p2 < $total - 2) {
                echo '<p class="hidden-xs"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></p><a href="'.$p1.$total.'" class="hidden-xs">'.$total.'</a>';
            }
            if ($p2 != $total) {
                echo '<a href="'.$p1.($p2 + 1).'"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
            }
            if ($p2 < ($total - 1)) {
                echo '<a href="'.$p1.$total.'" class="hidden-xs"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>';
            }
        echo '</div>
            </div>';
        }
}

function check_admin () {
if ($_SESSION['group_u']!=2) MessageSend(1, 'Нет доступа', '/', 0);
}

function not_found() {
    exit('Page 404');
}

function top( $title ) {
echo '
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="ru"> <!--<![endif]-->

<head>

    <meta charset="utf-8">

    <title></title>
    <meta name="description" content="">

    <link rel="shortcut icon" href="assets/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="assets/img/favicon/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/img/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/img/favicon/apple-touch-icon-114x114.png">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="assets/libs/bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="assets/libs/animate/animate.css">
    
    <link rel="stylesheet" href="assets/css/fonts.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/media.css">

    <script src="assets/libs/modernizr/modernizr.js"></script>

</head>

<body>

    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    
                </div>
            </div>
        </div>
    </header>

    <section class="menu">
        <div class="container">
            <div class="row">
                <div class="line_menu">
                    <a href="">Home</a>
                    <a href="">Gallery</a>
                    <a href="">About</a>
                    <a href="">Contact</a>
                </div>
            </div>
        </div>
    </section>

    <section class="main">
';
}




function bottom() {
echo '
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    
                </div>
            </div>
        </div>
    </footer>
    
    <div class="hidden"></div>

    <div class="loader">
        <div class="loader_inner"></div>
    </div>

    <!--[if lt IE 9]>
    <script src="assets/libs/html5shiv/es5-shim.min.js"></script>
    <script src="assets/libs/html5shiv/html5shiv.min.js"></script>
    <script src="assets/libs/html5shiv/html5shiv-printshiv.min.js"></script>
    <script src="assets/libs/respond/respond.min.js"></script>
    <![endif]-->

    <script src="assets/libs/jquery/jquery-1.11.2.min.js"></script>
    <script src="assets/libs/waypoints/waypoints.min.js"></script>
    <script src="assets/libs/animate/animate-css.js"></script>
    <script src="assets/libs/plugins-scroll/plugins-scroll.js"></script>
    
    <script src="assets/js/common.js"></script>
    
</body>
</html>';
}





?>