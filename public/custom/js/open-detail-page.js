$("document").ready(function(){
    $(".view-profile-btn").click(function(event){
        event.preventDefault();

        const link = $(this).attr("href");
        $(".content-wrapper").load(link);
    });

    $(".row-clickable").click(function (event) {
        event.preventDefault();

        const link = $(this).attr("data-href");
        $(".content-wrapper").load(link, function (response, status, xhr) {
            if (xhr.status === 403) {
                $(".content").html("");
                $(".content").append(response);
            }
        });
    });
});