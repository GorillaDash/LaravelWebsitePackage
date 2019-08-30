<template>
  <div>
    <div
      class="relative"
    >
      <div
        v-if="isDev"
        class="absolute pin-t pin-r"
      >
        <button
          class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded float-right"
          @click="show = true"
        >
          <font-awesome-icon
            icon="eye"
            size="xs"
          />
        </button>
      </div>
    </div>
    <div
      v-if="show"
      class="fixed pin z-50 overflow-auto flex bg-black-dark"
    >
      <div
        class="relative p-8 bg-white max-w-md m-auto flex-col flex"
      >
        <div class="px-6 py-4 flex">
          <div class="flex-none font-bold text-xl mb-2">
            GorillaDash Dev Tool
          </div>
          <div
            class="flex-grow"
          />
          <div
            class="flex-none"
          >
            <button
              class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded"
              @click="show = false"
            >
              X
            </button>
          </div>
        </div>
        <div class="border-t-2 border-grey" />
        <div class="overflow-auto text-left">
          <pre>
            <code>
  {{ results }}
            </code>
        </pre>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
  .bg-black-dark {
    background-color: rgba(0, 0, 0, 0.75);
  }
</style>

<script>
  export default {
    name: 'GdComponentDevTool',
    props: {
      results: {
        type: [Object, Array],
        default() {
          return null
        }
      }
    },
    data() {
      return {
        show: false,
      }
    },
    computed: {
      isDev() {
        return this.$gorilladash.devtool
      }
    },
  }
</script>
