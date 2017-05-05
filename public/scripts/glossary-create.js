(() => {
    $(document).ready(function() {
        // let glossary_term_id = 3;

        //
        // Handle the button for deleting a term from a glossary. Enables
        // checks so the number of terms is between 3 and 5.
        //
        $(document).on('click','.glossary-create-term-delete',function() {
            event.preventDefault()

            let numberOfCards = $(".glossary-term-card").not(".template").length

            if(numberOfCards <= 3) {
                alert("Sorry, you must have a minimum of 3 terms in this glossary.")
                return
            }

            if(numberOfCards <= 5) {
                $(".glossary-create-add-term").show()                
            }
            $(event.target).parents(".glossary-term-card").remove()
        })

        //
        // Handle the button for adding a term to a new glossary by cloning the 
        // template card. Has checks so that the number of terms is between
        // 3 and 5.
        //
        $(".glossary-create-add-term").click(function(event) {
            event.preventDefault()

            let numberOfCards = $(".glossary-term-card").not(".template").length

            if(numberOfCards == 5) {
                alert("Sorry, you may only add 5 terms to this glossary.")
                return;
            }
            else if(numberOfCards == 4) {
                $(".glossary-create-add-term").hide()
            }

            $('.glossary-term-card.template')
                .clone()
                .toggleClass("template")
                .css('display', 'block')
                .appendTo('.glossary-create-terms-form-group')
        })

        //
        // Handle the submit button for creating a glossay. Sets unique 'name'
        // attributes on each input and then submits the form.
        // 
        $(".glossary-create-submit").click(function() {
            $(".glossary-term-card").not(".template").each(function(e) {
                let term = $(this).find(".glossary-create-term-value").first()
                $(term).attr("name","term_"+e)
            })

            $("#glossary-create-form").submit()
        })
    })
})()