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
                        <li class="admin__menu-item"><a href="./admin_cabinet.php"
                                class="admin__menu-link">Замовлення</a></li>
                        <li class="admin__menu-item"><a href="./admin_tours.php" class="admin__menu-link">Тури</a></li>
                        <li class="admin__menu-item"><a href="./admin_users.php"
                                class="admin__menu-link">Користувачі</a></li>
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
                <h2 class="user__title">Тури</h2>
                <button class="addTour">Додати тур</button>
            </div>
        </div>
        <div class="admin__tours">
            <table class="admin__tours-table" cellspacing="0">
                <tr class="table__title-row">
                    <th class="table__title table__cell id">ID</th>
                    <th class="table__title table__cell">Назва</th>
                    <th class="table__title table__cell">Місто</th>
                    <th class="table__title table__cell">Тип</th>
                    <th class="table__title table__cell">Готель</th>
                    <th class="table__title table__cell">Кіл-ть зірок</th>
                    <th class="table__title table__cell">Вартість (грн)</th>
                    <th class="table__title table__cell">Мін. кіл. людей</th>
                    <th class="table__title table__cell">Макс. кіл. людей</th>
                </tr>
                <?php
                    $stmt = $pdo->query("SELECT tours.tour_id, tours.name, tours.city, tours.hotel, tours.stars, tours.price, tours.people_min, tours.people_max, tour_type.name AS 'tour_type' FROM tours JOIN tour_type ON tours.type = tour_type.type_id");
                    while($row = $stmt->fetch()){
                        echo '<tr class="table__row">
                        <td class="table__cell id">' . $row['tour_id'] . '</td>
                        <td class="table__cell name">' . $row['name'] . '</td>
                        <td class="table__cell city">' . $row['city'] . '</td>
                        <td class="table__cell">' . $row['tour_type'] . '</td>
                        <td class="table__cell">' . $row['hotel'] . '</td>
                        <td class="table__cell">' . $row['stars'] . '</td>
                        <td class="table__cell price">' . $row['price'] . '</td>
                        <td class="table__cell">' . $row['people_min'] . '</td>
                        <td class="table__cell">' . $row['people_max'] . '</td>
                        </tr>';
                    }
                ?>
            </table>
        </div>
    </section>

    <div class="modals">
        <div class="modal createTour">
            <input type="checkbox" name="hot_tour" id="hotTour" form="newTourCreate">
            <label for="hotTour">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_107_1093)">
                        <path
                            d="M15 30C23.2843 30 30 23.2843 30 15C30 6.71573 23.2843 0 15 0C6.71573 0 0 6.71573 0 15C0 23.2843 6.71573 30 15 30Z"
                            fill="#DD1E47" />
                        <path
                            d="M15 27.5C8.10756 27.5 2.5 21.8924 2.5 15C2.5 8.10753 8.10756 2.5 15 2.5C21.8927 2.5 27.5 8.10753 27.5 15C27.5 21.8924 21.8927 27.5 15 27.5Z"
                            fill="#FFEBD9" />
                        <path opacity="0.3"
                            d="M20.2901 15.4563L20.2818 15.4233C19.0643 11.6053 15.4364 8.89475 15.2821 8.78181L14.8138 8.4375L14.8442 9.01597C14.8442 9.04078 14.9295 11.283 12.7561 13.1479C10.3954 15.1754 10.4092 16.8474 10.4147 17.7455L10.4174 17.8694C10.4174 20.3183 12.2146 22.1493 14.7857 22.4512C14.6458 22.4292 14.5028 22.4007 14.3593 22.3568C13.5302 22.1006 13.0454 21.5193 12.9517 20.6819L12.9297 20.5167C12.8553 19.8693 12.7589 19.0677 14.1748 17.5471C14.7037 16.9797 15.1637 16.3681 15.5438 15.7318L15.7339 15.4123L15.9846 15.6877C16.7338 16.5058 17.3068 17.3323 17.6925 18.1366C18.0478 18.8473 18.0699 19.9712 18.0423 20.2109C17.9073 21.4339 17.0231 22.3457 15.8386 22.478C15.7614 22.4868 15.6458 22.4953 15.5043 22.4985C15.5168 22.4986 15.5286 22.5 15.5411 22.5C18.3398 22.5 20.5297 20.2494 20.5297 17.3763C20.5297 16.6877 20.2984 15.5059 20.2901 15.4563Z"
                            fill="black" />
                        <path
                            d="M19.8214 14.9876L19.8131 14.9546C18.5956 11.1366 14.9677 8.426 14.8134 8.31306L14.3451 7.96875L14.3754 8.54722C14.3754 8.57203 14.4608 10.8143 12.2874 12.6792C9.92662 14.7066 9.9404 16.3787 9.9459 17.2767L9.94868 17.4007C9.94868 19.8495 11.7458 21.6806 14.317 21.9824C14.1771 21.9604 14.0341 21.9319 13.8906 21.888C13.0614 21.6318 12.5766 21.0506 12.483 20.2132L12.4609 20.0479C12.3866 19.4006 12.2901 18.5989 13.706 17.0784C14.2349 16.5109 14.6949 15.8994 15.0751 15.263L15.2652 14.9435L15.5158 15.219C16.2651 16.0371 16.8381 16.8635 17.2237 17.6678C17.5791 18.3786 17.6011 19.5025 17.5736 19.7421C17.4386 20.9652 16.5543 21.877 15.3698 22.0092C15.2926 22.018 15.1771 22.0266 15.0356 22.0297C15.048 22.0298 15.0598 22.0312 15.0723 22.0312C17.8711 22.0312 20.061 19.7807 20.061 16.9076C20.061 16.2189 19.8296 15.0372 19.8214 14.9876Z"
                            fill="url(#paint0_linear_107_1093)" />
                    </g>
                    <defs>
                        <linearGradient id="paint0_linear_107_1093" x1="15.0032" y1="7.96875" x2="15.0032" y2="22.0312"
                            gradientUnits="userSpaceOnUse">
                            <stop stop-color="#FF8A00" />
                            <stop offset="1" stop-color="#FF0037" />
                        </linearGradient>
                        <clipPath id="clip0_107_1093">
                            <rect width="30" height="30" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
            </label>
            <div class="closeModals">
                <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M1.02238 0H4.43029L16.4148 13.9071L28.4561 0H31.9208L18.2324 15.8871L33 33H29.5353L16.4148 17.9143L3.40792 33H0L14.654 15.9343L1.02238 0Z"
                        fill="black" />
                </svg>
            </div>
            <div class="modal__body">
                <p class="modal__title">Створити тур</p>
                <form action="./php/tours/tour_create.php" method="post" id="newTourCreate">
                    <p class="modal__form-title">Назва</p>
                    <input type="text" name="name" class="modal__form-input" placeholder="1001 ніч в Японії">
                    <p class="modal__form-title">Місто</p>
                    <input type="text" name="city" class="modal__form-input" placeholder="Токіо">
                    <p class="modal__form-title">Тип</p>
                    <select name="type" class="modal__form-select modal__form-input">
                        <option value="1" class="modal__form-option">Екскурсія</option>
                        <option value="2" class="modal__form-option">Відпочинок</option>
                        <option value="3" class="modal__form-option">Шопінг</option>
                    </select>
                    <p class="modal__form-title">Готель</p>
                    <input type="text" name="hotel" class="modal__form-input" placeholder="Villa Krim">
                    <p class="modal__form-title">Кількість зірок</p>
                    <input type="number" max="5" min="0" name="stars" class="modal__form-input" placeholder="5">
                    <p class="modal__form-title">Кількість людей</p>
                    <div class="amountBox">
                        <input type="number" min="0" name="min_people" placeholder="1" class="modal__form-input">
                        <span>-</span>
                        <input type="number" min="0" name="max_people" placeholder="5" class="modal__form-input">
                    </div>
                    <p class="modal__form-title">Вартість (грн)</p>
                    <input type="number" min="0" name="price" class="modal__form-input" placeholder="12000">
                    <input type="submit" value="Створити" class="modal__form-submit">
                </form>
            </div>
        </div>

        <div class="modal deleteTour">
            <div class="closeModals">
                <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M1.02238 0H4.43029L16.4148 13.9071L28.4561 0H31.9208L18.2324 15.8871L33 33H29.5353L16.4148 17.9143L3.40792 33H0L14.654 15.9343L1.02238 0Z"
                        fill="black" />
                </svg>
            </div>
            <div class="modal__body">
                <p class="modal__title">Видалення туру</p>
                <p class="modal__text">
                    Ви дійсно хочете видалити тур - <span class="spanTourName"></span> в місті <span class="spanTourCity"></span> який коштує <span class="spanTourPrice"></span> грн?
                </p>
                <form action="./php/tours/tour_delete.php" method="post">
                    <input type="hidden" name="tour_id" class="deleteTourId">
                    <input type="submit" value="Видалити" class="deleteTourBtn">
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="./scripts/modals.js"></script>
</body>

</html>