<template>
   <div style="display:flex;">
      <input type="text" class="form-control">
      <button>Enviar</button>>
   </div>
</template>

<script>

export default {

   props: [user],

   data() {
      return {
         novaMensagem: ''
      }
   },

   methods: {
      enviarMessage: function () {

      }
   },


}

</script>