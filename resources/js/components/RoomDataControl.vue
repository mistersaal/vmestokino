<template>
    <b-modal :active="isOpen"
             has-modal-card
             trap-focus
             :can-cancel="['escape', 'outside']"
             @close="close"
             destroy-on-hide
    >
        <form @submit.prevent="createOrUpdate">
            <div class="modal-card modal-card__size">
                <header class="modal-card-head">
                    <p class="modal-card-title has-text-weight-bold has-text-primary">
                        {{ this.initRoom ? 'Редактировать комнату' : 'Создать комнату' }}
                    </p>
                </header>
                <section class="modal-card-body">
                    <b-field label="Тип комнаты">
                        <b-select v-model="room.type"
                                  validation-message="Выберите тип"
                                  required
                                  expanded
                        >
                            <option v-for="(type, id) in types"
                                    :key="type.id"
                                    :value="id"
                            >{{ type.name }}</option>
                        </b-select>
                    </b-field>
                    <b-field label="Ссылка на видео/фильм">
                        <b-input
                            placeholder="Ссылка"
                            :pattern="types[room.type].regExp"
                            validation-message="Неверная ссылка"
                            v-model="room.url"
                            maxlength="1000"
                            :has-counter="false"
                            required>
                        </b-input>
                    </b-field>
                    <b-checkbox :value="!room.everyone_control" @input="room.everyone_control = !$event">
                        Видео управляет только создатель комнаты
                    </b-checkbox>
                </section>
                <footer class="modal-card-foot">
                    <button class="button" type="button" @click="close">Отмена</button>
                    <button class="button is-primary" :disabled="isNotEdited">
                        {{ this.initRoom ? 'Сохранить' : 'Создать' }}
                    </button>
                </footer>
            </div>
        </form>
    </b-modal>
</template>

<script>
    export default {
        name: "RoomDataControl",
        props: ['initRoom', 'types', 'defaultType'],
        data() {
            return {
                room: this.initRoom ? _.clone(this.initRoom) : {
                    url: '',
                    everyone_control: false,
                    type: this.defaultType ?? 'youtube'
                },
            };
        },
        watch: {
            isOpen() {
                this.room = this.initRoom ? _.clone(this.initRoom) : {
                    url: '',
                    everyone_control: false,
                    type: this.defaultType ?? 'youtube'
                };
            },
            initRoom() {
                this.room = this.initRoom ? _.clone(this.initRoom) : {
                    url: '',
                    everyone_control: false,
                    type: this.defaultType ?? 'youtube'
                };
            },
            defaultType() {
                if (!this.initRoom) {
                    this.room.type = this.defaultType;
                }
            },
        },
        computed: {
            isNotEdited() {
                return _.isEqual(this.room, this.initRoom) || this.room.url === '';
            },
            isOpen() {
                return this.$route.hash === '#update' || this.$route.hash === '#create';
            }
        },
        methods: {
            close() {
                this.$router.back();
            },
            createOrUpdate() {
                if (!this.initRoom) {
                    axios.post('/room', this.room).then(response => {
                        this.$store.commit('createdOwnRoom', this.room);
                        this.$router.replace('/room');
                    }).catch(error => {
                        this.$buefy.snackbar.open({
                            message: error.response.data.message,
                            type: 'is-danger',
                            actionText: null,
                            position: 'is-top',
                            queue: false
                        })
                    });
                } else {
                    axios.put('/room', this.room).then(response => {
                        this.$store.commit('createdOwnRoom', this.room);
                        this.close();
                        this.$buefy.snackbar.open({
                            message: response.data.message,
                            actionText: null,
                            position: 'is-top',
                            queue: false
                        })
                    }).catch(error => {
                        this.$buefy.snackbar.open({
                            message: error.response.data.message,
                            type: 'is-danger',
                            actionText: null,
                            position: 'is-top',
                            queue: false
                        })
                    });
                }
            }
        }
    }
</script>

<style scoped>
    .modal-card__size {
        max-width: 500px;
        padding: 10px;
    }
</style>
