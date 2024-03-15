<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/connect/connect.php';
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Travel - Admin</title>

    <link rel="icon" type="image/png" href="favicon.png" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">


    <link rel="stylesheet" href="./styles/normalize.css">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/media.css">

    <style>
        body {
            background-color: var(--color-white);
        }        
    </style>
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__navigation">
                <a href="./index.php" class="header__link"><svg width="43" height="34" viewBox="0 0 43 34" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <rect width="43" height="33.0366" rx="6" fill="#FFB800" />
                        <path
                            d="M6.46748 33.0297L11.0122 0H1.74797C0.349593 0 0 1.40179 0 2.10268V31.1898C0 32.8019 1.22358 33.0881 1.83537 33.0297H6.46748Z"
                            fill="#080808" />
                        <path
                            d="M34.4328 7.20479L36.5304 0H41.2499C42.6482 0 42.9978 1.34724 42.9978 2.02085V31.0157C42.9978 32.4215 41.8325 32.9487 41.2499 33.0366H16.9531L18.6137 21.0872H31.6361L32.8596 13.0038H19.7499L20.6239 7.20479H34.4328Z"
                            fill="#080808" />
                    </svg></a>
                <nav class="admin__menu">
                    <ul class="admin__menu-list">
                        <li class="admin__menu-item"><a href="./admin_cabinet.php" class="admin__menu-link">Замовлення</a></li>
                        <li class="admin__menu-item"><a href="./admin_tours.php" class="admin__menu-link">Тури</a></li>
                        <li class="admin__menu-item"><a href="./admin_users.php" class="admin__menu-link">Користувачі</a></li>
                    </ul>
                </nav>
            </div>
            <?php
                if($_SESSION['login_status']){
                    switch($_SESSION['role']){
                        case 1:
                            echo '<a href="./admin_cabinet.php" class="header__user --logined"><span class="header__user-nickname">'. $_SESSION['username'] .'</span><img src="./content/user.png" alt="user icon" class="header__user-image"></a>';
                            break;
                        case 2:
                            echo '<a href="./manager_cabinet.php" class="header__user --logined"><span class="header__user-nickname">'. $_SESSION['username'] .'</span><img src="./content/user.png" alt="user icon" class="header__user-image"></a>';
                            break;
                        case 3:
                            echo '<a href="./user_cabinet.php" class="header__user --logined"><span class="header__user-nickname">'. $_SESSION['username'] .'</span><img src="./content/user.png" alt="user icon" class="header__user-image"></a>';
                            break;
                        };

                    }
                    else{
                        echo '<button class="header__user --unknown"><span class="header__user-nickname">Особистий кабінет</span><img src="./content/user.png" alt="user icon" class="header__user-image"></button>';
                    }
            ?>
        </div>
    </header>
    <section class="admin">
        <div class="admin__tours">
            <div class="admin__tours-header">
                <h2 class="user__title">Користувачі</h2>
            </div>
        </div>
        <div class="admin__tours">
            <table class="admin__users-table" cellspacing="0">
                <tr class="table__title-row">
                    <th class="table__title table__cell">Нікнейм</th>
                    <th class="table__title table__cell">Прізвище</th>
                    <th class="table__title table__cell">Ім’я</th>
                    <th class="table__title table__cell">Телефон</th>
                    <th class="table__title table__cell">Пошта</th>
                    <th class="table__title table__cell">Статус</th>
                </tr>
                <?php
                    $stmt = $pdo->query("SELECT user.*, banlist.user_id AS 'ban_status' FROM user LEFT JOIN banlist ON user.user_id = banlist.user_id WHERE role = 2 OR role = 3");
                    while($row= $stmt->fetch()){
                       echo '<tr class="table__row">
                        <td class="table__cell nickname">'. $row['login'] .'</td>
                        <td class="table__cell">'. $row['last_name'] .'</td>
                        <td class="table__cell">'. $row['first_name'] .'</td>
                        <td class="table__cell">'. $row['phone'] .'</td>
                        <td class="table__cell">'. $row['mail'] .'</td>';
                        if($row['ban_status']){
                            echo '<td class="table__cell status">Бан</td></tr>';
                        }
                        else{
                            echo '<td class="table__cell status">Активний</td></tr>'; 
                        }
                        
                    }
                ?>
                
            </table>
        </div>
    </section>

    <div class="modals">
        <div class="modal unblockUser">
            <div class="closeModals">
                <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M1.02238 0H4.43029L16.4148 13.9071L28.4561 0H31.9208L18.2324 15.8871L33 33H29.5353L16.4148 17.9143L3.40792 33H0L14.654 15.9343L1.02238 0Z"
                        fill="black" />
                </svg>
            </div>
            <div class="modal__body">
                <p class="modal__title">Користувач в бані</p>
                <p class="modal__text">
                    Якщо ви хочете його розблокувати, то натисніть кнопку “Підтвердити розблокування”!
                </p>
                <form action="./php/user/unblock.php" method="post">
                    <input type="hidden" name="username" class="unblockUserNickname">
                    <input type="submit" value="Підтвердити розблокування" class="unblockUserBtn">
                </form>
            </div>
        </div>
        <div class="modal blockUser">
            <div class="closeModals">
                <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M1.02238 0H4.43029L16.4148 13.9071L28.4561 0H31.9208L18.2324 15.8871L33 33H29.5353L16.4148 17.9143L3.40792 33H0L14.654 15.9343L1.02238 0Z"
                        fill="black" />
                </svg>
            </div>
            <div class="modal__body">
                <p class="modal__title">Користувач активний</p>
                <p class="modal__text">
                    Якщо ви хочете його заблокувати, то натисніть кнопку “Підтвердити блокування”!
                </p>
                <form action="./php/user/block.php" method="post">
                    <input type="hidden" name="username" class="blockUserNickname">
                    <input type="submit" value="Підтвердити блокування" class="blockUserBtn">
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="./scripts/modals.js"></script>
</body>

</html>