$('.tooltip').each(function(){
    var content = $(this).data('preview');
    var viewportWidth = $(window).width();

    $(this).tooltipster({
        position: 'right',
        offsetX : 40,
        content : $('<img src="' + content + '" width="400" />'),
        functionBefore : function(origin, continueTooltip){
            console.log(origin);
            console.log(origin.offset());
            if(origin.offset().left > (viewportWidth/2)){
                origin.tooltipster('option', 'position', 'left');
            }
            continueTooltip();
        }
    });
});

