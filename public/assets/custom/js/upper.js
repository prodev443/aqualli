$('input:text').keyup(
    function(e) {
        this.value = this.value.toUpperCase()
    }
)

$('textarea').keyup(
    function(e) {
        this.value = this.value.toUpperCase()
    }
)