<template>
  <div class="container mx-auto p-4">
    <div class="trafic-lights-flex">
      <!-- Элементы светофора -->
      <div class="traffic-lights">
        <!-- Генерация элементов светофора на основе данных lights -->
        <div v-for="(active, color) in lights" :key="color" :class="[color, active ? 'active' : 'inactive']"></div>
      </div>

      <!-- Кнопка запуска -->
      <button class="start" @click="go">Вперёд</button>
    </div>

    <table class="table-auto">
      <thead>
      <tr>
        <th>Сообщение</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="log in logs">
        <td>{{ log.message }}</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'TrafficLight',
  props: {
    logs: Array,
  },
  data() {
    return {
      // Инициализация состояния светофора
      lights: {
        red: false,
        yellow: false,
        green: false,
      }
    };
  },
  created() {
    // Подписка на событие изменения состояния светофора
    window.Echo.channel('traficLights.notification')
        .listen('.traficLights.change', ({data: {light}}) => {
          // Сброс всех цветов перед установкой нового
          this.resetLights();
          // Установка активного цвета
          this.lights[light] = true;
        });
    // Подписка на событие обновления лога
    window.Echo.channel('traficLightsLog.notification')
        .listen('.traficLightsLog.update', ({data}) => {
          // Добавление в начало лога нового сообщения
          this.logs.unshift(data);
        });
  },
  methods: {
    // Метод для сброса всех цветов светофора
    resetLights() {
      // Перебор всех цветов и установка их в состояние "неактивен"
      for (let key in this.lights) {
        this.lights[key] = false;
      }
    },
    go() {
      axios({
        method: "get",
        url: "/trafic-lights/go",
      })
    }
  }
};
</script>

<style lang="scss">
.container {
  text-align: center;

  .trafic-lights-flex {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 3em;

    .traffic-lights {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;

      div {
        color: #fff;
        display: flex;
        border-radius: 50%;
        width: 100px;
        height: 100px;
        justify-content: center;
        align-items: center;
        margin-bottom: 10px;
        background: #000;

        &.red.active {
          background: red;
        }

        &.yellow.active {
          background: yellow;
        }

        &.green.active {
          background: green;
        }
      }
    }

    .start {
      background: #447bba;
      padding: 8px 25px;
      border-radius: 3px;
      color: #fff;
    }
  }

  .table-auto {
    margin: 0 auto;
    margin-top: 2em;

    tr, th, td {
      border: solid 1px #bbbbbb;
      padding: 10px;
    }
  }
}
</style>
