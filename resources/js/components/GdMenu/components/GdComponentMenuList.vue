<template>
  <div
    v-if="menu"
    class="g-menu-list"
  >
    <ul>
      <li
        v-for="(item, key) in menu.children"
        :key="key"
        :style="{ width }"
        class="text-center"
        @mouseenter="hover(key)"
        @mouseout="hover(null)"
      >
        <slot
          :item="item"
          name="menu"
        >
          <a :href="item.url">
            {{ item.label }}
          </a>
        </slot>
      </li>
    </ul>
    <div
      v-for="(item, key) in menu.children"
      :key="key"
      :class="{ active: key === active }"
      class="g-list-item"
    >
      <slot
        :item="item"
        name="items"
      >
        <div
          v-for="level2 in item.children"
          :key="level2.name"
          class="nav-column"
        >
          <h3>{{ level2.name }}</h3>
          <ul>
            <li
              v-for="level3 in level2.children"
              :key="level3.name"
            >
              <a :href="level3.url">
                {{ level3.name }}
              </a>
            </li>
          </ul>
        </div>
      </slot>
    </div>
  </div>
</template>

<style scoped lang="scss">
.g-menu-list {
  width: 100%;
  height: 100%;
  position: relative;
  padding: 0;
  margin: 0;

  > ul {
    border: none;
    margin: 0;
    outline: none;
    padding: 0;

    > li {
      float: left;
      display: block;

      &:first-child > a {
        border-left: none;
        border-radius: 3px 0 0 3px;
      }

      > a {
        background: #fff;
        border-left: 1px solid #4b4441;
        border-right: 1px solid #312a27;
        border-top: 1px solid #312a27;
        display: block;
        font-weight: bold;
        height: 54px;
        line-height: 54px;
        padding: 0 20px;
        position: relative;
        -webkit-transition: all 0.3s ease;
        transition: all 0.3s ease;
      }
    }

    li {
      list-style: none;
    }
  }
  .g-list-item {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 0 0 3px 3px;
    position: absolute;
    display: block;
    left: 0;
    opacity: 0;
    overflow: hidden;
    top: 50px;
    -webkit-transition: all 0.3s ease 0.15s;
    transition: all 0.3s ease 0.15s;
    visibility: hidden;
    width: 100%;
    z-index: 9998;

    &.active {
      visibility: visible;
      opacity: 1;
      overflow: visible;
    }

    .nav-column {
      width: 20%;
      padding: 2.5%;
      display: inline-block;
      vertical-align: top;

      h3 {
        color: #372f2b;
        font-size: 14px;
        font-weight: bold;
        line-height: 18px;
        margin: 20px 0 10px 0;
        text-transform: uppercase;
      }

      li {
        a {
          color: #888;
          display: block;
          font-weight: bold;
          line-height: 26px;
        }
      }
    }
  }
}
</style>

<script>
export default {
  props: {
    menu: {
      type: Array,
      default: null
    }
  },
  data() {
    return {
      active: null
    }
  },
  computed: {
    width() {
      const width = 100 / this.menu.children.length
      return `${width}%`
    }
  },
  methods: {
    hover(index) {
      this.active = index
    }
  }
}
</script>
