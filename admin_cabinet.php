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
    <section class="manager">
        <h2 class="user__title">Персональні дані</h2>
        <div class="manager__header">
            <?php
                $stmt = $pdo->query("SELECT * FROM user WHERE login='". $_SESSION['username'] ."'");
                $row = $stmt->fetch();
                echo '<form action="./php/user/admin_change.php" method="post" class="manager__data" id="changeDataAdmin">
                <div class="manager__data-box"><p class="user__personal-title">Логін</p>
                <input type="text" name="login" class="user__personal-input" value="'. $row['login'] .'"></div>';
                echo '<div class="manager__data-box">
                <p class="user__personal-title">Пароль</p>
                <input type="password" name="password" class="user__personal-input" value="' . $row['password'] . '">
                </div>';
                echo '<div class="manager__data-box">
                <p class="user__personal-title">Пошта</p>
                <input type="text" name="mail" class="user__personal-input" value="' . $row['mail'] . '">
                </div>';
                echo '<input class="user__personal-submit" type="submit" value="Підтвердити">
                </form>';
            ?>
            <button class="logout">Вийти з кабінету</button>
        </div>
    
        <div class="manager__orders">
            <h2 class="user__title">Замовлення</h2>
            <table class="user__orders-title manager__orders-title" cellspacing="0">
                <tr class="table__title-row">
                    <th class="table__title table__cell">№ замовлення</th>
                    <th class="table__title table__cell">Назва</th>
                    <th class="table__title table__cell">Готель</th>
                    <th class="table__title table__cell">Ціна</th>
                    <th class="table__title table__cell">Кіл-ть людей</th>
                    <th class="table__title table__cell">Користувач</th>
                    <th class="table__title table__cell">Статус</th>
                    <th class="table__title table__cell">Знижка %</th>
                </tr>
                <?php
                    $stmt = $pdo->query("SELECT orders.order_id, orders.discount, user.login AS 'username', tours.name, tours.hotel, tours.price, payment_status.name AS 'order_status', orders.people_amount FROM orders JOIN user ON orders.user_id = user.user_id
                    JOIN tours ON orders.tour_id = tours.tour_id
                    JOIN payment_status ON orders.payment_status = payment_status.payment_status_id ORDER BY orders.order_id DESC");
                    while($row=$stmt->fetch()){
                        echo '<tr class="table__row">
                        <td class="table__cell id">' . $row['order_id'] . '</td>
                        <td class="table__cell">' . $row['name'] . '</td>
                        <td class="table__cell">' . $row['hotel'] . '</td>
                        <td class="table__cell">' . $row['price'] . '</td>
                        <td class="table__cell">' . $row['people_amount'] . '</td>
                        <td class="table__cell">' . $row['username'] . '</td>
                        <td class="table__cell status">' . $row['order_status'] . '</td>
                        <td class="table__cell discount">' . $row['discount'] . '</td>
                        </tr>';
                    }
                ?>
            </table>
        </div>
    </section>

    <div class="modals">
        <div class="modal manageOrder">
            <div class="closeModals">
                <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M1.02238 0H4.43029L16.4148 13.9071L28.4561 0H31.9208L18.2324 15.8871L33 33H29.5353L16.4148 17.9143L3.40792 33H0L14.654 15.9343L1.02238 0Z"
                        fill="black" />
                </svg>
            </div>
            <div class="modal__body">
                <p class="modal__title">Замовлення <span class="orderId"></span></p>
                <form action="./php/orders/order_edit.php" method="post" id="editTour">
                    <input type="hidden" name="order_id">
                    <p class="modal__form-title">Знижка %</p>
                    <input type="number" min="0" name="discount" class="modal__form-input" placeholder="1">
                    <p class="modal__form-title">Тип</p>
                    <select name="status" class="modal__form-select modal__form-input">
                        <option value="1" class="modal__form-option">Зареєстровано</option>
                        <option value="2" class="modal__form-option">Сплачено</option>
                        <option value="3" class="modal__form-option">Відмінено</option>
                    </select>
                    <input type="submit" value="Змінити дані" class="modal__form-submit">
                </form>
            </div>
        </div>
    </div>

    <div class="popup">
        <div class="popup__title"></div>
        <p class="popup__text"></p>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="./scripts/modals.js"></script>
    <script src="./scripts/ajax.js"></script>
</body>

</html>