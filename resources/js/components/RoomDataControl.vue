<template>
    <b-modal :active="isOpen"
             has-modal-card
             trap-focus
             :can-cancel="['escape', 'outside']"
             @close="close"
             destroy-on-hide
    >
        <form @submit.prevent="createOrUpdate">
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title has-text-weight-bold">
                        {{ this.initRoom ? 'Редактировать комнату' : 'Создать комнату' }}
                    </p>
                </header>
                <section class="modal-card-body">
                    <b-field label="Тип видео/фильма">
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
                            type="url"
                            :validation-message="errorUrl"
                            v-model="room.url"
                            maxlength="1000"
                            :has-counter="false"
                            required>
                        </b-input>
                    </b-field>
                    <b-switch :value="!room.everyone_control"
                                @input="room.everyone_control = !$event"
                    >
                        Видео управляет только создатель комнаты
                    </b-switch>
                </section>
                <footer class="modal-card-foot">
                    <b-button @click="close">Отмена</b-button>
                    <b-button type="is-primary" native-type="submit" :disabled="isNotEdited" :loading="isLoading">
                        {{ this.initRoom ? 'Сохранить' : 'Создать' }}
                    </b-button>
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
                isLoading: false
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
            },
            errorUrl() {
                return this.room.url.length === 0 ? 'Обязательное поле' : 'Неверная ссылка';
            },
        },
        methods: {
            close() {
                this.$router.back();
            },
            createOrUpdate() {
                this.isLoading = true;
                if (!this.initRoom) {
                    axios.post('/room', this.room).then(response => {
                        this.$store.commit('createdOwnRoom', this.room);
                        this.isLoading = false;
                        this.$router.replace('/room');
                    }).catch(error => {
                        this.$buefy.toast.open({
                            message: error.response.data.message,
                            type: 'is-danger',
                            queue: false
                        })
                        this.isLoading = false;
                    });
                } else {
                    axios.put('/room', this.room).then(response => {
                        this.$store.commit('createdOwnRoom', this.room);
                        this.close();
                        this.$buefy.toast.open({message: response.data.message, queue: false});
                        this.isLoading = false;
                    }).catch(error => {
                        this.$buefy.toast.open({
                            message: error.response.data.message,
                            type: 'is-danger',
                            queue: false
                        })
                        this.isLoading = false;
                    });
                }
            }
        }
    }
</script>

<style scoped>

</style>
