<template>
  <div class="w-100">
    <gd-data-menu :name="name">
      <template slot-scope="{ results }">
        <gd-component-menu-list :menu="getMenu(results)">
          <template
            v-if="$scopedSlots.menu"
            slot="menu"
            slot-scope="props"
          >
            <slot
              :item="props.item"
              name="menu"
            />
          </template>
          <template
            v-if="$scopedSlots.items"
            slot="items"
            slot-scope="props"
          >
            <slot
              :item="props.item"
              name="items"
            />
          </template>
        </gd-component-menu-list>
      </template>
    </gd-data-menu>
  </div>
</template>

<style scoped></style>

<script>
import GdComponentMenuList from '@/components/GdMenu/components/GdComponentMenuList'
import GdDataMenu from '@/components/GdMenu/data/GdDataMenu';

export default {
  components: {
    GdComponentMenuList,
    GdDataMenu,
  },
  props: {
    name: {
      required: true,
      type: String
    }
  },
  data() {
    return {
      value: []
    }
  },
  methods: {
    getMenu(result) {
      if (result.length > 0) {
        return result[0].menu_json
      }

      return [];
    },
  }
}
</script>
