$(document).on("click", "#dashboardArrow", function () {

    $("#dashboardDropdown").slideToggle(200);
    $("#dashboardArrow").toggleClass("rotate-180");

});

$(document).on("click", "#adgroupsArrow", function () {

    $("#adgroupsDropdown").slideToggle(200);
    $(this).find("svg").toggleClass("rotate-180");

});

$(document).on("click", "#productsArrow", function () {

    $("#productsDropdown").slideToggle(200);
    $(this).find("svg").toggleClass("rotate-180");

});

$(document).ready(function () {

    const btn = $("#createCollectionBtn");
    const popup = $("#collectionPopup");

    btn.on("click", function (e) {
        e.stopPropagation();

        const rect = this.getBoundingClientRect();

        popup.css({
            top: (rect.top + $(window).scrollTop()) + "px",
            left: (rect.right + 10) + "px"
        });

        popup.toggleClass("hidden");
    });

    $(document).on("click", function () {
        popup.addClass("hidden");
    });

    popup.on("click", function (e) {
        e.stopPropagation();
    });

});

$(document).on("click", "#collectionPopup", function (e) {
    e.stopPropagation();
});


$(document).on("click", "#openBidPopupBtn", function (e) {
    e.stopPropagation();

    let btn = $(this);
    let popup = $("#productBidPopup");

    let rect = btn[0].getBoundingClientRect();

    popup.css({
        top: (rect.top + $(window).scrollTop()) + "px",
        left: (rect.right + 10) + "px"
    });

    popup.toggleClass("hidden");
});

$(document).on("click", function () {
    $("#productBidPopup").addClass("hidden");
});

$(document).on("click", "#productBidPopup", function (e) {
    e.stopPropagation();
});

$(document).on("click", ".bid-tab", function () {

    let type = $(this).data("type");

    $(".bid-tab").removeClass("bg-orange-400 text-white").addClass("bg-gray-200");
    $(this).addClass("bg-orange-400 text-white");

    $(".bid-box").addClass("hidden");

    if (type === "set") {
        $("#setBox").removeClass("hidden");
    } 
    else if (type === "increase") {
        $("#increaseBox").removeClass("hidden");
    }
    else if (type === "decrease") {
        $("#decreaseBox").removeClass("hidden");
    }
});

$(document).on("click", "#collectionArrow", function (e) {
    e.preventDefault();
    e.stopPropagation();

    let dropdown = $("#collectionDropdown");
    let icon = $(this).find("svg");

    dropdown.toggleClass("hidden");
    icon.toggleClass("rotate-180");
});

$(document).on("click", "#allAdgroupsArrow", function (e) {
    e.preventDefault();
    e.stopPropagation();

    $("#allAdgroupsDropdown").toggleClass("hidden");
    let icon = $(this).find("svg");
    icon.toggleClass("rotate-180");
});

$(document).ready(function () {

    const btn = $("#createCollection");
    const popup = $("#createCollectionPopup");

    btn.on("click", function (e) {
        e.stopPropagation();

        const rect = this.getBoundingClientRect();

        popup.css({
            top: (rect.top + $(window).scrollTop()) + "px",
            left: (rect.right + 10) + "px"
        });

        popup.toggleClass("hidden");
    });

    $(document).on("click", function () {
        popup.addClass("hidden");
    });

    popup.on("click", function (e) {
        e.stopPropagation();
    });

});

$(document).on("click", "#createCollectionPopup", function (e) {
    e.stopPropagation();
});

$(document).ready(function () {

    const btn = $("#updateCollection");
    const popup = $("#updateCollectionPopup");

    btn.on("click", function (e) {
        e.stopPropagation();

        const rect = this.getBoundingClientRect();

        popup.css({
            top: ((rect.top - 20) + $(window).scrollTop()) + "px",
            left: (rect.right + 10) + "px"
        });

        $("#allAdgroupCollectionPopup").addClass("hidden");

        popup.toggleClass("hidden");
    });

    $(document).on("click", function () {
        popup.addClass("hidden");
    });

    popup.on("click", function (e) {
        e.stopPropagation();
    });

});

$("#updateCollectionPopup").on("click", "#collectionDropdown li", function () {

    let name = $(this).text().trim();
    let id = $(this).data("id");

    $("#update_collection_name").val(name);
    $("#updateCollectionPopup").attr("data-id", id);
    $("#collectionDropdown").addClass("hidden");
});