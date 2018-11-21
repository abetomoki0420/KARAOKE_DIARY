<template>
  <transition name="modal" appear>
    <div class="modal modal-overlay column">
      <div class="modal-window">
          <i class="fas fa-circle-notch fa-spin fa-10x" style="color:white"></i>
      </div>
    </div>
  </transition>
</template>

<style lang="scss" scoped>
.modal {
  &.modal-overlay {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    z-index: 30;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
  }

  &-window {
    background: rgba(0,0,0,0);
    border-radius: 4px;
    overflow: hidden;
  }

  &-content {
    text-align:center ;
    padding: 10px 20px;
    margin: 0 ;
  }

  &-footer {
    background: #ccc;
    padding: 10px;
    text-align: right;
  }
}

// オーバーレイのトランジション
.modal-enter-active, .modal-leave-active {
  transition: opacity 0.2s;

  // オーバーレイに包含されているモーダルウィンドウのトランジション
  .modal-window {
    transition: opacity 0.2s, transform 0.2s;
  }
}

// ディレイを付けるとモーダルウィンドウが消えた後にオーバーレイが消える
.modal-leave-active {
  // transition: opacity 0.6s ease 0.4s;
  transition: opacity 0.4s;
}

.modal-enter, .modal-leave-to {
  opacity: 0;

  .modal-window {
    opacity: 0;
  }
}
</style>
