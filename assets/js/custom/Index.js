function Index(ok_translation, homepage_click_stats_url, click_stats_path)
{
  let self = this
  self.ok_translation = ok_translation
  self.homepage_click_stats_url = homepage_click_stats_url
  self.click_stats_path = click_stats_path
  
   function performClickStatisticRequest(href, type, isRecommendedProgram, userSpecificRecommendation, programID)
   {
    let url = self.click_stats_path
    let params = {}
    
    if (!isRecommendedProgram)
    {
      url = self.homepage_click_stats_url
      if (['featured', 'newest', 'mostDownloaded', 'mostViewed', 'random'].indexOf(type) === -1)
      {
        alert('You clicked at a program of an unknown section!')
        return
      }
      params = {type: type, programID: programID}
    }
    else
    {
      params = {
        type             : type,
        recFromID        : 0,
        recID            : programID,
        isScratchProgram : 0,
        recIsUserSpecific: userSpecificRecommendation
      }
    }
    
    $.post(url, params, function (data) {
      if (data === 'error')
      {
        console.log('No click statistic is created!')
      }
    }).always(function () {
      window.location.href = href
    })
    .fail(function (data) {
      console.log(data)
    })
    
  }
  
  self.init = function() {
    $(document).on('click', '.program', function() {
      let clicked_program_id = this.id.replace('program-', '')
      this.className += ' visited-program'
      let stored_visits = sessionStorage.getItem('visits')
    
      if (!stored_visits)
      {
        let new_visits = [clicked_program_id]
        sessionStorage.setItem('visits', JSON.stringify(new_visits))
      }
      else
      {
        let parsed_visits = JSON.parse(stored_visits)
        if (!($.inArray(clicked_program_id, parsed_visits) >= 0))
        {
          parsed_visits.push(clicked_program_id)
          sessionStorage.setItem('visits', JSON.stringify(parsed_visits))
        }
      }
    })
  
    $(document).one('click', '#feature-slider > div > div > a', function(event) {
      event.preventDefault()
      let href = $(this).attr('href')
      let programID = ((href.indexOf('project') > 0) ? (href.split('project/')[1]).split('?')[0] : 0)
      let type = 'featured'
      performClickStatisticRequest(href, type, false, 0, programID)
    })
  
    $(document).one('click', '.rec-programs', function(event) {
      event.preventDefault()
      let isRecommendedProgram = $(this).hasClass('homepage-recommended-programs')
      let type = (isRecommendedProgram ? 'rec_homepage' : $(this).parent('.program').parent('.programs').parent().attr('id'))
      let href = $(this).attr('href')
      let recommendedProgramID = ((href.indexOf('project') > 0) ? (href.split('project/')[1]).split('?')[0] : 0)
      let userSpecificRecommendation = ((href.indexOf('rec_user_specific=') > 0) ? parseInt((href.split('rec_user_specific=')[1].match(/[0-9]+/))[0]) : 0)
      performClickStatisticRequest(href, type, isRecommendedProgram, userSpecificRecommendation, recommendedProgramID)
    })
  
    $(document).on('click', '#help-button', function() {
      swal({
          title            : $(this).attr('data-help-title'),
          text             : $(this).attr('data-help-description'),
          showCancelButton : false,
          confirmButtonText: self.ok_translation,
          closeOnConfirm   : true,
          type             : 'question',
        },
        function() {
        }
      )
    })
  }
  
  
}