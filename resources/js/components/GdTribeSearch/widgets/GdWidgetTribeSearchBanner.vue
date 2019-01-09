<template>
  <b-container
    fluid
    class="tribe-search-banner-outer-container"
  >
    <b-row
      v-if="!tribe"
      no-gutters
    >
      <b-col cols="4">
        <slot name="title" />
      </b-col>
      <b-col cols="8">
        <gd-widget-tribe-search-input
          v-bind="$attrs"
          @change="onChange"
        />
        <a
          v-if="urlValidate"
          :href="tribeListUrl"
        >
          {{ tribeListCaption }}
        </a>
      </b-col>
    </b-row>
    <b-row
      v-else
      no-gutters
    >
      <b-col
        cols="12"
        class="tribe-search-store-inner-container"
      >
        <h3>{{ tribeName }}</h3>
        <b-link>Contact Us</b-link>
        |
        <b-link @click="onChangeStore">
          Change Store
        </b-link>
      </b-col>
    </b-row>
  </b-container>
</template>

<style scoped lang="scss">
.tribe-search-banner-outer-container {
  margin: 0;
  padding: 20px 0;
  min-height: 100px;
}

.tribe-search-store-inner-container {
  text-align: right;
}
</style>

<script>
import { Rule } from '@cesium133/forgjs'
import GdWidgetTribeSearchInput from './GdWidgetTribeSearchInput'

const STOREKEY = 'gd-store'
const urlRule = new Rule({
  type: 'url'
})

export default {
  components: {
    GdWidgetTribeSearchInput
  },
  inheritAttrs: false,
  props: {
    tribeListUrl: {
      type: String,
      required: true
    },
    tribeListCaption: {
      type: String,
      required: true
    },
    prefix: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      tribeValue: null
    }
  },
  computed: {
    urlValidate() {
      const valid = urlRule.test(this.tribeListUrl)
      if (!valid) {
        console.error('The tribe-list-url invalid')
      }
      return valid
    },
    tribeName() {
      if (this.tribe) {
        const prefix = this.prefix ? `${this.prefix} ` : ''
        return `${prefix}${this.tribe['name']}`
      }

      return null
    },
    tribe: {
      set(value) {
        if (value) {
          localStorage.setItem(STOREKEY, JSON.stringify(value))
        } else {
          localStorage.removeItem(STOREKEY)
        }
        this.tribeValue = value
      },
      get() {
        if (this.tribeValue) {
          return this.tribeValue
        }

        if (
          typeof localStorage !== 'undefined' &&
          localStorage.getItem(STOREKEY)
        ) {
          return this.tribeValue
        }
        return null
      }
    }
  },
  methods: {
    onChangeStore() {
      this.tribe = null
      this.$emit('reset')
    },
    onChange(tribe) {
      this.tribe = tribe
      this.$emit('change', tribe)
    }
  }
}
</script>
