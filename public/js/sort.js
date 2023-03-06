$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$(document).ready(function () {
    $(".sortable-block").sortable({
        handle: ".sortable-block-handle",
        axis: "y",
        stop: function (event, ui) {
            changeBlockOrder();
        },
    });
    $(".sortable-group").sortable({
        handle: ".sortable-group-handle",
        axis: "y",
        stop: function (event, ui) {
            changeGroupOrder();
        },
    });
    $(".sortable-link").sortable({
        handle: ".sortable-link-handle",
        axis: "xy",
        stop: function (event, ui) {
            changeLinkOrder();
        },
    });
});

function changeBlockOrder(blockId) {
    var data = [];
    $(".slinks-table").each(function (i, obj) {
        let blockId = $("#" + obj.id + " .block-id")
            .attr("id")
            .split("block-id-")[1];
        data.push({
            id: blockId,
            newOrder: i + 1,
        });
    });
    data = JSON.stringify(data);
    $.ajax({
        headers: {
            Accept: "application/json",
            "Content-type": "application/json",
        },
        data: data,
        type: "POST",
        url: "/changeBlockOrder",
        dataType: "json",
    });
}

function changeGroupOrder() {
    var data = [];
    $(".slinks-group").each(function (i, obj) {
        let groupId = $("#" + obj.id + " .group-id")
            .attr("id")
            .split("group-id-")[1];
        data.push({
            id: groupId,
            newOrder: i + 1,
        });
    });
    data = JSON.stringify(data);
    $.ajax({
        headers: {
            Accept: "application/json",
            "Content-type": "application/json",
        },
        data: data,
        type: "POST",
        url: "/changeGroupOrder",
        dataType: "json",
    });
}

function changeLinkOrder() {
    var data = [];
    $(".slinks-link").each(function (i, obj) {
        let linkId = $("#" + obj.id + " .link-id")
            .attr("id")
            .split("link-id-")[1];
        data.push({
            id: linkId,
            newOrder: i + 1,
        });
    });
    data = JSON.stringify(data);
    $.ajax({
        headers: {
            Accept: "application/json",
            "Content-type": "application/json",
        },
        data: data,
        type: "POST",
        url: "/changeLinkOrder",
        dataType: "json",
    });
}
