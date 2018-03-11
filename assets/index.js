$(document).ready(function () {
    var numero = 1
    var nbr_max_backup = 3
    /**
     * Partie qui ajoute un serveur : backup
     */
    $('.add-srv').click(function (event) {
       if (numero <= nbr_max_backup) {
            var element = '<div></div><label for="site_adresse_ip_'+numero+'">Adresse IP du container et port d\'écoute de l\'application</label>' +
                '<input type="text" class="form-control" id="site_adresse_ip_' + numero + '" name="site_adresse_ip_'+numero+'" placeholder="172.18.0.'+numero+':80">' +
                '<span id="help-site_adresse_ip_'+numero+'"></span>'+
                '<span class="add-srv" style="float: right; padding-right:6px;font:1.3rem italic Consolas;"> En tant que backup  <input type="checkbox" name="backup_'+numero+'" class="form-check-inline"></span></div>'

            $('.site_ajouter_adresse').append(element).slideDown()
            numero += 1
           if(numero === 3){
               $(this).hide()
           }
        }

    })

    /**
     * Partie qui envoie les informations
     */
    $('#form-send').submit(function (event) {
        event.preventDefault()

        $.post('execute.php', $(this).serialize(), function (message) {
           if(message.error){
                   $('#help-'+message.champ).slideDown().css('display', 'block').html(message.error).delay(3000).slideUp()
           }
           console.log(message)
        }, 'json')
    })

})
