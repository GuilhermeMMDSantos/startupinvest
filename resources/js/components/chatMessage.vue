<template>
  <ul>
    <li v-for="mensagem in mensagens">
      <div>
        <h1>{{ mensagem.user.name }}</h1>
        <p>{{ mensagem.message }}</p>
      </div>
    </li>
  </ul>
</template>

<script>

export default {
  props: ['messages']
}

</script>