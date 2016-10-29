/**
 * Created by Ucizi on 29/10/16.
 */
/**
 $(document).ready(function(){
    $('[data-toggle="popover"]').popover();
});
 */

$(document).ready(function () {
    $("[rel=details]").popover({
        trigger: 'click',
        placement: 'bottom',
        html: 'true',
        content: '' +
        '<form>' +
            '<div class="form-group">' +
                '<input type="email" class="form-control" placeholder="Email...">' +
            '</div>' +
            '<div class="form-group">' +
                '<input type="password" class="form-control" placeholder="Password...">' +
            '</div>' +
            '<div class="checkbox">' +
                '<label><input type="checkbox"> Remember me</label>' +
            '</div>' +
            '<div class="form-inline">' +
                '<button type="submit" class="btn btn-default btn-sm">Login</button>' +
            '</div>' +
        '</form>',
        template: '' +
        '<div class="popover">' +
            '<div class="arrow"></div>' +
            '<h3 class="popover-title"></h3>' +
            '<div class="popover-content"></div>' +
            '<div class="popover-footer">' +
                '<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#popUpWindow">' +
                    'Create Account' +
                '</button>' +
            '</div>' +
        '</div>'
    });
});
