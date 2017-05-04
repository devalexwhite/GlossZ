(() => {
    $(document).ready(function() {
        let edit_mode = false     

        //
        // Handle the glossary edit/save button
        //
        $(".glossary-enable-edit").click(function() {
            edit_mode = !edit_mode

            if(edit_mode) {
                $(".glossary-enable-edit").removeClass('fa-pencil').addClass('fa-floppy-o')
                $("#glossary-title").attr("contenteditable","true")
                $("#glossary-title").focus()
            }
            else {
                $("#glossary-title").attr("contenteditable","false")  
                $(".glossary-enable-edit").removeClass('fa-floppy-o').addClass('fa-pencil')                

                $.ajax({
                    type: "POST",
                    url: window.location.pathname + "/update",
                    data: {
                        "title": $("#glossary-title").text()
                    }
                })
                .done(function(data) {
                    console.log(data)
                    if(data.errors && data.errors.length > 0) {
                        alert('failed to save')        
                    }
                })
            }
        })

        //
        // Handle the glossary delete button
        //
        $(".glossary-delete").click(function() {
            var cResult = confirm("Are you sure you wish to delete this glossary?")

            if(cResult == true) {
                window.location = window.location.pathname + "/delete"
            }
            else {
                return
            }
        })

        //
        // Handle the addition of a new term
        //
        $(document).on('click','.glossary-translations-add-button', function() {
            let termID = $("#glossary-translations-add-form").attr('term-id')

            $.ajax({
                type: "POST",
                url: "/term/" + termID + "/translation",
                data: $("#glossary-translations-add-form").serialize()
            })
            .done(function(data) {
                if(data.errors.length > 0) {
                    alert("Encountered an error, please try again.")                        
                }
                else {
                    $.ajax({
                        type: "GET",
                        url: "/term/" + termID + "/translation"
                    })
                    .done(function(twigData) {
                        $(".glossary-terms-term-card[term-id='" + termID + "']").html(twigData)
                    })
                }
            })
        })
    })
})()