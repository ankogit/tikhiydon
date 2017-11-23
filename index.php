<?

$name_web_site = "mandarinshow.ru"; //Название сайта
$admin_email = "ya.tolik-a@yandex.ru"; //Почта админа
$admin_login = "root"; //Логин админа
$admin_pass = ""; //Пароль админа

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

$CONNECT = mysql_connect("127.0.0.1","root","") or die(mysql_error());
 mysql_select_db("phprun") or die(mysql_error());

session_start();

if ($_SESSION['id']) {
    $_SESSION['logged'] = 'TRUE';
}
else $_SESSION['logged'] = 'FALSE';

if ( file_exists('all/'.$page.'.php') ) include 'all/'.$page.'.php';
else if ( $_SESSION['id'] and file_exists('auth/'.$page.'.php') ) include 'auth/'.$page.'.php';
else if ( !$_SESSION['id'] and file_exists('guest/'.$page.'.php') ) include 'guest/'.$page.'.php';
else if ( $_SESSION['admin'] and file_exists('admin/'.$page.'.php') ) include 'admin/'.$page.'.php';
else if ( $_SERVER['REQUEST_URI'] == '/') include 'all/index.php';
else include 'error/page-404.php';

function message($text) {
    exit ('{"message" : "'.$text.'"}');
}
function like($data) {
    exit ('{"like" : "'.$data.'"}');
}
function go( $url ) {
    exit ('{"go" : "'.$url.'"}');
}
function cform() {
    exit ('{"select" : ":input"}');
}
function random_str( $num = 30 ) {
    return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $num);
}

function captcha() {
    $questions = array(
        1 => 'Фамилия Толстого?',
        2 => 'Фамилия Чехова?',
        3 => 'Фамилия Достоевского?',
        4 => 'Фамилия Гололя?',
        5 => 'Фамилия Тургенева?',
        );
    $num = mt_rand(1, count($questions) );
    $_SESSION['captcha'] = $num;

    echo $questions[$num];
}

function MessageSend($p1, $p2, $p3 = '', $p4 = 1) {
if ($p1 == 1) $p1 = 'Ошибка';
else if ($p1 == 2) $p1 = 'Подсказка';
else if ($p1 == 3) $p1 = 'Информация';
$_SESSION['message'] = '<div class="MessageBlock"><b>'.$p1.'</b>: '.$p2.'</div>';
if ($p4) {
Location($p3);
}
}
function MessageShow() {
if ($_SESSION['message'])$Message = $_SESSION['message'];
echo $Message;
unset($_SESSION['message']);
}
function Location ($p1) {
if (!$p1) $p1 = $_SERVER['HTTP_REFERER'];
exit(header('Location: '.$p1));
}
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
function sendmessage($sender, $subj) {
global $CONNECT;
    //$sender = FormChars($p1, 1);
    //$recipient = FormChars($p2);

    if ($sender == $_SESSION['email']) message('Вы не можете отправить сообщение самому себе');

    $m_q_user = mysql_fetch_assoc(mysql_query("SELECT `id` FROM `users` WHERE `email` = '$sender'"));
    
if (!$m_q_user) message('Пользователь не найден');
    
    
$m_q_dialog = mysql_fetch_assoc(mysql_query("SELECT `id` FROM `dialog` WHERE `recive` = $m_q_user[id] AND `send` = $_SESSION[id] OR `recive` = $_SESSION[id] AND `send` = $m_q_user[id]"));
    
    

if ($m_q_dialog) {

    $DID = $m_q_dialog['id'];
    mysql_query("UPDATE `dialog` SET `status` = 0, `send` = $_SESSION[id], `recive` = $m_q_user[id] WHERE `id` = $m_q_dialog[id]");
printf('обновили');
    } else {


    mysql_query("INSERT INTO `dialog` VALUES ('', 0, $_SESSION[id], $m_q_user[id])");
    $DID = mysql_insert_id();
    printf('создали');
    }
    
    
    
    
    mysql_query("INSERT INTO `message` VALUES ('', $DID, $_SESSION[id], '$subj', NOW())");
    //$DID = mysql_insert_id();
    echo $m_q_user['id'];
        echo $_SESSION['id'];
echo $m_q_dialog['id']; echo 'did'; echo $DID;
        
    }
function my_avatar() {
    if (!empty($_SESSION['avatar'])) {
    echo '<img src="/assets/img/avatars'.$_SESSION['avatar'].'.jpg" alt="avatar">';
    } else {
        echo '<img src="/assets/img/avatars/avatar.jpeg" alt="avatar">';
    }
}

function check_admin () {
if ($_SESSION['group_u']!=2) MessageSend(1, 'Нет доступа', '/', 0);
}
/*
$Count = mysql_query("SELECT COUNT(`id`) FROM `dialog` WHERE `recive` = $_SESSION[id] AND `status` = 0");
if (empty($Count)) MessageSend(2, 'У вас нет новых сообщений', '', 0);
else {
    if (mysql_num_rows($Count)) {
        $Count = mysql_fetch_row($Count);
    if ($Count[0] != 0) MessageSend(2, 'У вас есть непрочитанные диалоги ( <b>'.$Count[0].'</b> )', '', 0);
     else {
        MessageSend(2, 'У вас нет новых сообщений', '', 0);
        }
    }
}
*/
function captcha_valid() {
    $answers = array(
        1 => 'толстой',
        2 => 'чехов',
        3 => 'достоевский',
        4 => 'гоголь',
        5 => 'тургенев',
        );
    $strtolower = mb_strtolower($_POST['captcha'], 'UTF-8');
    if ( $_SESSION['captcha'] != array_search( $strtolower, $answers) )
        message('Ответ не верен');
    

}

function email_valid() {
    if ( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        message('E-mail указан неверно');
}

function password_valid() {
    if (!preg_match('/^[A-z0-9]{6,15}$/', $_POST['password']) )
        message('Пароль указан неверно. Критерии: A-z0-9 и от 6 до 15 символов');
    $_POST['password'] = md5($_POST['password']);
}
function url_valid() {
    //if (!preg_match('/^(http|https|ftp)://([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?/?/i', $_POST['url'])) 
        message('Url указан не верно!');
}
function name_valid() {
    if (!preg_match( '/^([а-яА-ЯЁёa-zA-Z]+)$/u', $_POST['name']) )
        message('Имя или Фамилия указано неверно');
}
function sur_name_valid() {
    if (!preg_match( '/^([а-яА-ЯЁёa-zA-Z]+)$/u', $_POST['sur_name']) )
        message('Имя или Фамилия указано неверно');
}
function country_valid() {
    if (!preg_match( '/^([а-яА-ЯЁёa-zA-Z]+)$/u', $_POST['country']) )
        message('Страна указана неверно');
}
function year_valid() {
    if (!preg_match( '/^([0-9]{4})$/', $_POST['year']) )
        message('Год рожденья указан неверно. 4 цифры');
}
function password_repeat() {
    if ($_POST['password']!=$_POST['rep_password']) message('Пароли не совпадают!');
}

function hideEmail ( $email ) {
    $explode = explode('@', $email);
    return $explode[0].'@******';
}

function not_found() {
    exit('Page 404');
}
function session_exit() {}

function top( $title ) {
    echo '<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$title.'</title>
<link rel="stylesheet" href="/assets/style.css">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<script
  src="https://code.jquery.com/jquery-1.12.4.js"
  integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="
  crossorigin="anonymous"></script>
<script src="/assets/scripts.js"></script>
<script src="/assets/libs/Magnific-Popup/jquery.magnific-popup.min.js"></script>
<script src="/assets/imageupload.js"></script>
<script src="/assets/libs/jscroll/jquery.jscroll.min.js" type="text/javascript"></script>
<script src="https://use.fontawesome.com/c40b7447b3.js"></script>

<link rel="stylesheet" href="/assets/libs/Magnific-Popup/magnific-popup.css">
<link rel="stylesheet" href="/assets/libs/bootstrap/css/bootstrap-grid.min.css" />
</head>

<body>

<div class="wrapper">

<div class="menu">
'.(isset($_SESSION["id"]) ? '
    <p>Добро пожаловать <br><span>'.$_SESSION["email"].'</span></p>
    ' : '').'
<a href="/">Главная</a>
<a href="/news">Статьи</a>
<a href="/contact">Обратная связь</a>
<a href="/reviews">Отзывы</a>
 '.(!isset($_SESSION["id"]) ? ' <a href="/login">Вход</a>
<a href="/register">Регистрация</a>' : '').'
 '.(isset($_SESSION["id"]) ? '
    <a href="/user/'.$_SESSION["id"].'">Мой профиль</a>
    <a href="/im">Диалоги</a>
    <a href="/logout">Выход</a>
    ' : '').'
</div>


<div class="content">
<div id="counter"></div>
<div class="block">
';
}




function bottom() {
    include 'assets/script-count.php';
echo '
</div>
</div>
</div>
</body>
</html>';
}





?>

<script>
/*
     var logged = "<?=$_SESSION['logged']?>";
function count_message() {
    $.get('/counter', function ( data ) {

        
            $('#counter').html( data );
        
    })
}

 $(document).ready(function() {
    if( logged == 'TRUE') {
    count_message();
    setInterval('count_message()',3000);
}  else {
    
}
 });
 */
</script>