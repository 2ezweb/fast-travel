$('.logout').on('click', function(){
    $.post('../php/user/logout.php').done(function(data){
        location.href = '../index.php';
    });
})

$('#loginForm').on('submit', function(event){
    event.preventDefault();
    let username = $(this).children('input[name="username"]').val();
    let password = $(this).children('input[name="password"]').val();
    $.post('../php/user/login.php', {username: username, password: password}).done(function(data){
        if(data.error){
            $('.popup__title').html('Помилка');
            $('.popup__text').html(data.msg);
            showPopup(5000);
        }
        else{
            location.reload(true);
        }
    });
})
$('.catalogue__button.makeOrder').on('click', function(){
    let maxPeople = $(this).siblings('.catalogue__header').find('.catalogue__people').text().split(' - ');
    let tourId = $(this).parents('.catalogue__item').children('.tour__id').val();
    $.post('../php/orders/order_check.php', {}).done(function(data){
        if(data.error){
            $('.modal.makeOrder').find('.modal__title').text('Помилка');
            $('.modal.makeOrder').find('.modal__text').html(data.msg);
        }
        else{
            $('.modal.makeOrder').find('.makeOrderForm').fadeIn();
            $('.modal.makeOrder').find('input[name="people_amount"]').attr('max', maxPeople[1]);
            $('.modal.makeOrder').find('input[name="tour_id"]').val(tourId);
        }
    });
})
$('.catalogue__button.edit').on('click', function(){
    if($(this).parents('.catalogue__item').find('.catalogue__item-hot').length > 0){
        $('#hotTour').prop('checked', true);
    }
    $('#editTour').find('input[name="tour_id"]').val($(this).parents('.catalogue__item').find('.tour__id').val());
    $('#editTour').find('input[name="name"]').val($(this).parents('.catalogue__item').find('.catalogue__title').text());
    $('#editTour').find('input[name="city"]').val($(this).parents('.catalogue__item').find('.catalogue__city span').text());
    var typeText = $(this).parents('.catalogue__item').find('.catalogue__type span').text().trim();
    $('#editTour').find('.modal__form-option').each(function(){
        if($(this).text() == typeText){
            $(this).prop('selected', true);
        }
        else{
            return
        }
    })

    $('#editTour').find('input[name="hotel"]').val($(this).parents('.catalogue__item').find('.catalogue__hotel-name').text());
    $('#editTour').find('input[name="stars"]').val($(this).parents('.catalogue__item').find('.catalogue__hotel-stars img').length);
    let peopleArray = $(this).parents('.catalogue__item').find('.catalogue__people').text().split(' - ')
    $('#editTour').find('input[name="min_people"]').val(peopleArray[0]);
    $('#editTour').find('input[name="max_people"]').val(peopleArray[1]);
    $('#editTour').find('input[name="price"]').val($(this).parents('.catalogue__item').find('.catalogue__price span').text());
})
$('#changeDataAdmin').on('submit', function(event){
    event.preventDefault();
    let username = $(this).find('input[name="login"]').val();
    let password = $(this).find('input[name="password"]').val();
    let mail = $(this).find('input[name="mail"]').val();
    $.post('../php/user/admin_change.php', {login: username, password: password, mail: mail}).done(function(data){
        if(data.error){
            $('.popup__title').html('Помилка');
            $('.popup__text').html(data.msg);
            showPopup(5000);
        }
        else{
            location.reload(true);
        }
    });
});
$('#changeDataUser').on('submit', function(event){
    event.preventDefault();
    let username = $(this).find('input[name="login"]').val();
    let password = $(this).find('input[name="password"]').val();
    let lastName = $(this).find('input[name="last_name"]').val();
    let firstName = $(this).find('input[name="first_name"]').val();
    let phone = $(this).find('input[name="phone"]').val();
    let mail = $(this).find('input[name="mail"]').val();
    $.post('../php/user/user_change.php', {login: username, password: password, last_name: lastName, first_name: firstName, phone: phone, mail: mail}).done(function(data){
        if(data.error){
            $('.popup__title').html('Помилка');
            $('.popup__text').html(data.msg);
            showPopup(5000);
        }
        else{
            location.reload(true);
        }
    });
})
$('#registrationForm').on('submit', function(event){
    event.preventDefault();
    let username = $(this).children('input[name="username"]').val();
    let password = $(this).children('input[name="password"]').val();
    let passwordSecond = $(this).children('input[name="password_second"]').val();
    $.post('../php/user/registration.php', {username: username, password: password, password_second: passwordSecond}).done(function(data){
        if(data.error){
            $('.popup__title').html('Помилка');
            $('.popup__text').html(data.msg);
            showPopup(5000);
        }
        else{
            $.post('../php/user/login.php', {username: username, password: password}).done(function(){
                location.reload(true);
            })
        }
    });
});


$('#restorePassForm').on('submit', function(event){
    event.preventDefault();
    let username = $(this).children('input[name="username"]').val();
    $.post('../php/user/restore.php', {username: username}).done(function(data){
        if(data.error){
            $('.popup__title').html('Помилка');
            $('.popup__text').html(data.msg);
            showPopup(7000);
        }
        else{
            // location.reload(true);
            $('.popup__title').html('Відновлення');
            $('.popup__text').html(data.msg);
            closeModals();
            showPopup(7000);

        }
    });
})


showPopup = (time) =>{
    $('.popup').fadeIn();
    setTimeout(function(){
        $('.popup').fadeOut();
    }, time);
}