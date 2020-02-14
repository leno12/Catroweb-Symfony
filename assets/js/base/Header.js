function Header()
{
  self = this
  
  self.init = function()
  {
    $(document).ready(function() {
      $('.search-icon-header').on('click', function() {
        $(this).hide()
        const input_group = $("#search-input-group-header");
        input_group.removeClass('d-none')
      
        let search_header = $('.search-input-header')
        let val = search_header.val()
        search_header
        .focus()
        .val('')
        .val(val)
      })
    })
  }
  
  
  
  
}