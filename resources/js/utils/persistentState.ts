import {ref} from 'vue';

const _show_group = ref<boolean|undefined>(localStorage.getItem('show_group') === 'true');

const toggleShowGroup = () => {
    _show_group.value = !_show_group.value;
    localStorage.setItem('show_group', _show_group.value.toString());
}

const _show_follower = ref<boolean|undefined>(localStorage.getItem('show_follower') === 'true');

const toggleShowFollower = () => {
    _show_follower.value = !_show_follower.value;
    localStorage.setItem('show_follower', _show_follower.value.toString());
}

export { _show_group, toggleShowGroup, _show_follower, toggleShowFollower}