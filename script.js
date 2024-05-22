$(".messages").animate({ scrollTop: $(document).height() }, "fast");         // animation défilement vers le bas messagerie

$("#profile-img").click(function() {
  $("#status-options").toggleClass("active");              // Défilement options de changement de statut couleur utilisateur
});

$(".expand-button").click(function() {
  $("#profile").toggleClass("expanded");
  $("#contacts").toggleClass("expanded");
});

// _______________________________________________________________________________

// --------------------------------------------
  
// Statut de connexion

// --------------------------------------------



$("#status-options ul li").click(function() {
  $("#profile-img").removeClass();
  $("#status-online").removeClass("active");
  $("#status-away").removeClass("active");
  $("#status-busy").removeClass("active");
  $("#status-offline").removeClass("active");
  $(this).addClass("active");

  if($("#status-online").hasClass("active")) {
    $("#profile-img").addClass("online");
  } else if ($("#status-away").hasClass("active")) {
    $("#profile-img").addClass("away");
  } else if ($("#status-busy").hasClass("active")) {
    $("#profile-img").addClass("busy");
  } else if ($("#status-offline").hasClass("active")) {
    $("#profile-img").addClass("offline");
  } else {
    $("#profile-img").removeClass();
  };

  $("#status-options").removeClass("active");
});



// ________________________________________________________________________________

// ----------------------

// Envoi de message

// ----------------------


function newMessage() {
  message = $(".message-input input").val();
  if($.trim(message) == '') {
    return false;                                    // Vérification si entrée non-vide
  }

  
  $.ajax({

    type: "POST",

    url: "send_message.php", // Remplacez par l'URL de votre script serveur

    data: {

      sender: "utilisateur1", // Remplacez par l'identifiant de l'expéditeur

      receiver: "utilisateur2", // Remplacez par l'identifiant du destinataire

      content: message

    },

    success: function(response) {

      // Gérer la réponse du script serveur, si nécessaire

      // Par exemple, mettre à jour l'affichage du chat

    },

    error: function(jqXHR, textStatus, errorThrown) {

      // Gérer les erreurs, si nécessaire

    }

  });
  
  $('<li class="sent"><img src="https://i.pinimg.com/736x/7a/f0/04/7af004703ee797756ba58c0b186fdca9.jpg" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
  $('.message-input input').val(null);
  $('.contact.active .preview').html('<span>You: </span>' + message);
  $(".messages").animate({ scrollTop: $(document).height() }, "fast");
};

$('.submit').click(function() {
  newMessage();
});

$(window).on('keydown', function(e) {             // Fonction pour déclancher newMessage
  if (e.which == 13) {
    newMessage();
    return false;
  }
});