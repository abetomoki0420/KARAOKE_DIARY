<template>
  <span @click="openModal" class="icon is-large has-text-primary addbtn">
    <i class="fas fa-plus-circle fa-md"></i>
  </span>
</template>

<script>
export default {
  methods:{
    openModal: function(){
        this.$emit('openModal')
    }
  },
}
</script>
