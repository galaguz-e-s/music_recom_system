const buttonModalPreferencesOpen = document.getElementById('openModalPreferences')
var modalPreferences = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalPreferences'))

buttonModalPreferencesOpen.addEventListener('click', e => {
    modalPreferences.show();
    fetchPreferencesData('#preferences__main');
})

const buttonMoodChoice = document.getElementById('mood_list')
buttonMoodChoice.addEventListener('change', e => {
    var targetMood = buttonMoodChoice.value;
    if (targetMood != '') {
        fetchPreferencesData('#mood__main', mood = targetMood);
    }
})

function fetchPreferencesData(targetModal, mood = '') {
    fetch('get_preferences.php?' + (mood != '' ? "mood=" + mood : ''))
        .then(response => {
            if (!response.ok) {
                throw new Error(response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data && data.success == true) {
                let html = `
                    <table id="songs">
                `;
                data.tracks.forEach(song => {
                    html = html + `<tr><td> <img class='album' src='img_assets/album_stand_in.png'> </td><td>${song.title || ''}</td>
                    <td>${song.artist || ''}</td>
                    <td><audio data-id='${song.id || ''}' controls controlslist='nodownload nofullscreen'>
            <source src='${song.link || ''}' type='audio/mpeg'>
            Your browser does not support the audio element.
        </audio></td></tr>`;
                })
                html = html + `</table>`;
                document.querySelector(targetModal).innerHTML = html;

            } else {
                console.error('Нет данных');
                let html = `<div>Произошла ошибка при получении данных</div>`;
                document.querySelector(targetModal).innerHTML = html;
            }
        })
        .catch(error => console.error('Ошибка:', error));
};