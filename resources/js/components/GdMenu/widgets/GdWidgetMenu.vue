<template>
  <div class="w-100">
    <gd-component-menu-list :menu="getMenu(value)">
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
  </div>
</template>

<style scoped></style>

<script>
import GdComponentMenuList from '@/components/GdMenu/components/GdComponentMenuList'

export default {
  components: {
    GdComponentMenuList
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
  computed: {
    params() {
      if (this.name) {
        return { name: this.name }
      }

      return {}
    }
  },
  mounted() {
    this.fetch()
  },
  methods: {
    getMenu(result) {
      if (result.length > 0) {
        return result[0].menu_json
      }

      return null
    },
    async fetch() {
      this.value = await this.$gorilladash.query('websiteMenus', this.params)
    }
  }
}
</script>
