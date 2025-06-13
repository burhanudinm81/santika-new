$("document").ready(function(){
    $(".back-btn").click(function(event){
        event.preventDefault();

        const link = $(this).attr("href");
        $(".content-wrapper").load(link);
    });
});