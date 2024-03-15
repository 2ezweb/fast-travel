$('.modal__switch-item').on('click', function(){
    $('.modal__switch-item').removeClass('--active');
    $(this).addClass('--active');
    $('.modal__form').removeClass('--active');
    if($(this).hasClass('login')){
        $('.modal__form.login').addClass('--active');
    }
    else{
        $('.modal__form.registration').addClass('--active');
    }
});


$('.manager__orders-title').on('click', '.table__row', function(){
    let status = $(this).children('.table__cell.status').html();
    $('input[name="order_id"]').val($(this).children('.table__cell.id').html());
    $('.modal__form-input[name="discount"]').val($(this).children('.table__cell.discount').html());
    $('.orderId').html($(this).children('.table__cell.id').html());
    $('.modal__form-select option').filter(function() {
        return $(this).text() === status;
    }).prop('selected', true);
    openModals('manageOrder');
});

$('.catalogue__button.makeOrder').on('click', function(){
    openModals('makeOrder');
})
$('.catalogue__button.edit').on('click', function(){
    openModals('tourEdit');
})
$('.addTour').on('click', function(){
    openModals('createTour');
});

$('.admin__tours-table').on('click', '.table__row', function(){
    $('.deleteTourId').val($(this).children('.table__cell.id').html());
    $('.spanTourName').html($(this).children('.table__cell.name').html());
    $('.spanTourCity').html($(this).children('.table__cell.city').html());
    $('.spanTourPrice').html($(this).children('.table__cell.price').html());
    openModals('deleteTour')
});

$('.admin__users-table').on('click', '.table__row', function(){
    if($(this).children('.table__cell.status').html() == 'Бан'){
        $('.unblockUserNickname').val($(this).children('.table__cell.nickname').html());
        openModals('unblockUser');
    }
    else{
        $('.blockUserNickname').val($(this).children('.table__cell.nickname').html());
        openModals('blockUser'); 
    }
});

$('.modal__form-link.forget').on('click', function(){
    openModals('forget');
});

$('.header__user.--unknown').on('click', function(){
    openModals('login');
});
$('.closeModals').on('click', function(){
    closeModals();
});









//Функция для открытия модальног окна
openModals = (name) => {
    closeModals();
    $('.modals').addClass('--opened');
    $(`.modal.${name}`).addClass('--opened')
};
//Функция для закрытия модального окна
closeModals = () => {
    $('.modals').removeClass('--opened');
    $('.modal').removeClass('--opened');
};