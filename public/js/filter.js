$(document).ready(function () {
    $('.search').keyup(() => {
        $('table').hide()
        let searchText = $('.search').val()
        $('.searchable .app-name').each(function(i, obj) {            
            let elementText = $(obj).text().trim()
            if (elementText.toLowerCase().includes(searchText.toLowerCase())) {                
                $(this).parents().eq(4).show()
            }
        })
    })
})