<template>
  <div class="g-tribe-search-contain">
    <b-input-group :size="$attrs.size">
      <font-awesome-icon
        v-if="ready"
        :icon="icons"
        :class="$attrs.size"
        :spin="loading"
        class="g-tribe-input-icon"
      />
      <b-form-input
        v-model="text"
        v-bind="$attrs"
        type="text"
        class="g-tribe-search-input"
        @input="onInput"
        @click.native="onClick"
      />
    </b-input-group>
    <b-list-group v-if="showList">
      <b-list-group-item>
        <span>Closest store to</span>
        <strong>{{ result.locality }} {{ result.state }}</strong>
      </b-list-group-item>
      <b-list-group-item
        v-for="item in result.tribes"
        :key="item.id"
        href="#"
        button
        class="flex-column align-items-start"
        @click="onSelect(item)"
      >
        <div
          class="d-flex w-100 justify-content-between find-tribe-select-option"
        >
          {{ item.name }}
        </div>
        <p
          v-if="showAddress"
          class="mb-1"
        >
          {{ appendTribeAddress(item) }}
        </p>
      </b-list-group-item>
    </b-list-group>
  </div>
</template>

<style scoped lang="scss">
.g-tribe-search-contain {
  position: relative;

  .list-group {
    position: absolute;
    width: 100%;
    z-index: 9999;
  }

  .g-tribe-search-input {
    border-radius: 0;
  }

  .g-tribe-input-icon {
    position: absolute;
    z-index: 10;
    top: 12px;
    left: 10px;

    &.sm {
      top: 8px;
      left: 10px;
    }

    .find-tribe-select-option {
      cursor: pointer;
    }
  }

  .form-control {
    padding-left: 30px;
  }
}
</style>

<script>
import collect from 'collect.js'
import debounce from 'lodash.debounce'

export default {
  inheritAttrs: false,
  props: {
    showAddress: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      text: null,
      loading: false,
      result: [],
      tribe: null,
      showList: false,
      searching: false,
      ready: false
    }
  },
  computed: {
    icons() {
      if (this.loading) {
        return 'sync-alt'
      }

      return 'search'
    }
  },
  watch: {
    text(val) {
      if (this.searching) {
        this.loading = true
        this.request(val)
      }
    }
  },
  mounted() {
    this.ready = true
  },
  methods: {
    onInput() {
      this.searching = true
    },
    onClick() {
      if (this.text) {
        this.loading = true
        this.request(this.text)
      }
    },
    appendTribeAddress(tribe) {
      const { address_1, address_2, locality, state, country } = tribe

      return collect([address_1, address_2, locality, state, country])
        .reject(value => !value)
        .implode(' ')
    },
    request: debounce(async function(value) {
      const response = await this.$gorilladash.$axios.post(
        `https://gorilladash.com/endpoint/js/tribe-search/${
          this.$gorilladash.config.tribeType
        }?search=${value}`,
        {},
        {
          headers: {
            Authorization: `Bearer ${this.$gorilladash.config.token}`,
            'X-Requested-With': 'XMLHttpRequest'
          }
        }
      )
      this.loading = false
      this.result = response.data
      this.showList = true
    }),
    onSelect(tribe) {
      this.tribe = tribe
      this.showList = false
      this.searching = false
      this.text = tribe.name
      this.$emit('change', tribe)
    }
  }
}
</script>
