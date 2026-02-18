Система подбора музыки по настроению (PHP + LLM API)

Используемые фреймворки:
•	Front-end – Bootstrap5
Используемые языки:
•	PHP 7.2;
•	MySQL 8.0;
•	JavaScript
 <img width="248" height="236" alt="image" src="https://github.com/user-attachments/assets/0de07779-48f2-467f-9a8f-fa1dede1f0e6" />


Схема базы данных:
 <img width="978" height="441" alt="image" src="https://github.com/user-attachments/assets/4cf0a371-1ab1-4ad1-9eb5-645595f3bccf" />

 
Связь файлов:
<img width="808" height="759" alt="image" src="https://github.com/user-attachments/assets/be57d2ab-4cf8-4095-8006-48b430c36237" />
<img width="805" height="686" alt="image" src="https://github.com/user-attachments/assets/5d2e568a-d9e1-4d3f-bccc-ecd9def3bce6" />
 
 
Необходимые действия для запуска:
•	Создать базы данных и импорт music_website.sql;
•	В файле bd.php изменить hostname, username, password, database при создании mysqli (3 строка);
•	В файле llm_query изменить $apiKey и $agentAccessId (конец файла).


Примеры запросов
По настроению:
'Analyze mood descriptions of preferencedTracks and choose 10 IDs that best match the required mood in random order: '. $tracks_all .'. The required mood is referenced in "targetMood". Prioritize targetMood above any other moods. DO NOT include the preferencedTracks if they do not fit the targetMood. Respond ONLY in format {"track_ids": [1,2,3,4,5,6,7,8,9,10]}. Use only provided IDs. Return EXACTLY 10 IDs.';

На основе предпочтений:
'Analyze track titles, genres, artists and mood descriptions and choose 10 IDs that best match the preferencedTracks in random order: '. $tracks_all .'. Prioritize mood above other characteristics. Priority of given characteristics from the most important to least: mood, genre, artist, track title. Respond ONLY in format {"track_ids": [1,2,3,4,5,6,7,8,9,10]}. Use only provided IDs. Return EXACTLY 10 IDs.';

Формат вывода от ЛЛМ: {"track_ids": [1,2,3,4,5,6,7,8,9,10]}
Формат вывода из функции: php-массив ['success' => true, 'track_ids' => $result['track_ids']] в случае успеха, 
['success' => false, 'error' => 'No valid track_ids in response'] в случае неудачи

