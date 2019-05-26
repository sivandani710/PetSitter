$(function(){
    $(".dropdown-menu").on('click', 'li a', function(){
      $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
      //$(this).parents(".dropdown").find('.btn').val($(this).data('value'));
      $('#date-id').val($(this).parent().val());
    });
});