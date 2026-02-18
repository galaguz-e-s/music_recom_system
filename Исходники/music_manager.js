const audioList = document.querySelectorAll('audio')
let currentAudio;
let additionTimer = setTimeout(async () => {
				let response2 = await fetch('likes.php?query=call');
				let result2 = await response2.text(); 
				additionTimer = null;
			}, 10);

Array.prototype.forEach.call(audioList, audio => {
	audio.addEventListener('play', e => {
		if (currentAudio) {
			if (currentAudio != e.target) {
				currentAudio.pause();
				currentAudio.currentTime = 0;
				songActionManagement(e.target.getAttribute('data-id'), 'Listen');
			}
		}
		else songActionManagement(e.target.getAttribute('data-id'), 'Listen');
		currentAudio = e.target
	})
})

const likesList = document.querySelectorAll('button.like_btn')
Array.prototype.forEach.call(likesList, likeButton => {
	likeButton.addEventListener('click', e => {
		if (likeButton.classList.contains('liked')) {
			likeButton.classList.remove('liked');
			songActionManagement(likeButton.getAttribute('data-id'), 'Like', false);

		}
		else {
			likeButton.classList.add('liked');
			songActionManagement(likeButton.getAttribute('data-id'), 'Like', true);
		}

	})
})

async function songActionManagement(songID, action, isAdded = false) {
	if (action == 'Like') {
		let response1 = await fetch('likes.php?query=input&songID=' + songID + '&action=' + action + '&isAdded=' + isAdded);
		let result1 = await response1.text();

		if (additionTimer == null) {
			additionTimer = setTimeout(async () => {
				let response2 = await fetch('likes.php?query=call');
				let result2 = await response2.text(); 
				additionTimer = null;
			}, 3000);
		}
		
	}
	else {
		let response = await fetch('listens.php?songID=' + songID + '&action=' + action);
		let result = await response.text();
	}
}
