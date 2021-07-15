$(document).ready(function() {
    MemberDashboard.init();
});

var MemberDashboard = {
    eventSendInterest: function() {
        memberDashboard = this;
        $(".profile_container").on('click', '.send_interest', function() {
            memberDashboard.sendInterest(this);
        });

        $(".profile_container").on('click', '.add_profile_to_shortlist', function() {
            memberDashboard.shortListProfile(this);
        });

        $(".profile_container").on('click', '.add_profile_to_ignore_list', function() {
            memberDashboard.ignoreTheProfile(this);
        });

        $(".profile_container").on('click', '.accept_profile_interest', function() {
            memberDashboard.acceptProfileInterest(this);
        });

        $(".profile_container").on('click', '.not_interest', function() {
            memberDashboard.notInterest(this);
        });

        $(".profile_container").on('click', '.remove_from_ignore_list', function() {
            memberDashboard.removeFromIgnoreRequest(this);
        });

        $(".profile_container").on('click', '.remove_from_short_list', function() {
            memberDashboard.removeFromShortList(this);
        });

        $(".profile_container").on('click', '.delete_my_request', function() {
            memberDashboard.deleteMyRequest(this);
        });


    },

    sendInterest: function(profile) {
        var profileContainer = $(profile).closest('.member_profile');
        $.ajax({
            url: "/sendinterest/" + profileContainer.find('[name="member_code"]').val(),
            type: "post",
            dataType: "json",
            success: function(data) {
                alert('success');
                profileContainer.fadeOut().remove();
            },
            error: function(jqXHR, exception) {
                alert(jqXHR.responseText);
            }
        });

    },
    shortListProfile: function(profile) {
        var profileContainer = $(profile).closest('.member_profile');
        $.ajax({
            url: "/addshortlist/" + profileContainer.find('[name="member_code"]').val(),
            type: "post",
            dataType: "json",
            success: function(data) {
                alert('success');
                profileContainer.fadeOut().remove();
            },
            error: function(jqXHR, exception) {
                alert(jqXHR.responseText);
            }
        });

    },
    ignoreTheProfile: function(profile) {
        var profileContainer = $(profile).closest('.member_profile');
        $.ajax({
            url: "/addignore/" + profileContainer.find('[name="member_code"]').val(),
            type: "post",
            dataType: "json",
            success: function(data) {
                alert('success');
                profileContainer.fadeOut().remove();
            },
            error: function(jqXHR, exception) {
                alert(jqXHR.responseText);
            }
        });
    },
    acceptProfileInterest: function(profile) {
        var profileContainer = $(profile).closest('.member_profile');
        $.ajax({
            url: "/accept_profile_interest/" + profileContainer.find('[name="member_code"]').val(),
            type: "post",
            dataType: "json",
            success: function(data) {
                alert('success');
                profileContainer.fadeOut().remove();
            },
            error: function(jqXHR, exception) {
                alert(jqXHR.responseText);
            }
        });
    },
    notInterest: function(profile) {
        var profileContainer = $(profile).closest('.member_profile');
        $.ajax({
            url: "/not_interest/" + profileContainer.find('[name="member_code"]').val(),
            type: "post",
            dataType: "json",
            success: function(data) {
                alert('success');
                profileContainer.fadeOut().remove();
            },
            error: function(jqXHR, exception) {
                alert(jqXHR.responseText);
            }
        });
    },
    removeFromIgnoreRequest: function(profile) {
        var profileContainer = $(profile).closest('.member_profile');
        $.ajax({
            url: "/remove_from_ignore_list/" + profileContainer.find('[name="member_code"]').val(),
            type: "post",
            dataType: "json",
            success: function(data) {
                alert('success');
                profileContainer.fadeOut().remove();
            },
            error: function(jqXHR, exception) {
                alert(jqXHR.responseText);
            }
        });
    },
    removeFromShortList: function(profile) {
        var profileContainer = $(profile).closest('.member_profile');
        $.ajax({
            url: "/remove_from_short_list/" + profileContainer.find('[name="member_code"]').val(),
            type: "post",
            dataType: "json",
            success: function(data) {
                alert('success');
                profileContainer.fadeOut().remove();
            },
            error: function(jqXHR, exception) {
                alert(jqXHR.responseText);
            }
        });
    },
    deleteMyRequest: function(profile) {
        var profileContainer = $(profile).closest('.member_profile');
        $.ajax({
            url: "/delete_my_request/" + profileContainer.find('[name="member_code"]').val(),
            type: "post",
            dataType: "json",
            success: function(data) {
                alert('success');
                profileContainer.fadeOut().remove();
            },
            error: function(jqXHR, exception) {
                alert(jqXHR.responseText);
            }
        });
    },
    blockProfile: function(profile) {
        var profileContainer = $(profile).closest('.member_profile');
        $.ajax({
            url: "/block_profile/" + profileContainer.find('[name="member_code"]').val(),
            type: "post",
            dataType: "json",
            success: function(data) {
                alert('success');
                profileContainer.fadeOut().remove();
            },
            error: function(jqXHR, exception) {
                alert(jqXHR.responseText);
            }
        });
    },
    init: function() {
        this.eventSendInterest();
    }
};