<template>
  <transition name="mymodal" appear>
    <div class="mymodal mymodal-overlay" @click.self="$emit('close')">
      <div class="mymodal-window">
        <div class="mymodal-content">
          <slot/>
        </div>
        <footer class="mymodal-footer">
          <slot name="submit">
            <button @click="$emit('close')">Close</button>
          </slot>
        </footer>
      </div>
    </div>
  </transition>
</template>

<style lang="scss" scoped>
.mymodal {
  &.mymodal-overlay {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    z-index: 30;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
  }

  &-window {
    background: #fff;
    border-radius: 4px;
    overflow: hidden;
  }

  &-content {
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
.mymodal-enter-active, .mymodal-leave-active {
  transition: opacity 0.4s;

  // オーバーレイに包含されているモーダルウィンドウのトランジション
  .mymodal-window {
    transition: opacity 0.4s, transform 0.4s;
  }
}

// ディレイを付けるとモーダルウィンドウが消えた後にオーバーレイが消える
.mymodal-leave-active {
  transition: opacity 0.6s ease 0.4s;
}

.mymodal-enter, .mymodal-leave-to {
  opacity: 0;

  .mymodal-window {
    opacity: 0;
    transform: translateY(-100px);
  }
}
</style>
