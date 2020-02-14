function manageBroadCastNotifications()
{
  $('.btn').click(function () {
    $('.resultBox').html('')
    
    var message = $('#msg').val()
    var title = $('#title').val()
    
    $.ajax({
      url    : 'send',
      type   : 'get', //send it through get method
      data   : {Title: title, Message: message},
      success: function (data) {
        if (data === 'OK')
        {
          $('.resultBox').switchClass('error', 'success')
        }
        else
        {
          $('.resultBox').switchClass('success', 'error')
        }
        $('.resultBox').html(data)
        //Do Something
      }
    })
  })
}
function manageBackupProgress(backup_command_link, tester)
{
  tester.forEach(function (item, index) {
    console.log(item.name, index);
  });
  
  backup_create_link = backup_command_link
  
  function initBackupProgress ()
  {
    $('#backup-modal').modal('show')
  }
  
  $(function () {
    $('#btnCreateBackup').click(function () {
      $('#btnCreateBackup').prop('disabled', true)
      $('#btnCreateBackup').text('Backup started...')
      $.ajax
      ({
        type: 'GET',
        url : backup_create_link,
        
        success: function (data) {
          window.location.reload()
        },
        error  : function (jqXHR, error) {
          window.location.reload()
        }
      })
      initBackupProgress()
    })
  })
}

