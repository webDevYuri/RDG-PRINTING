<?php
header('Content-Type: application/json');

$bannedWords = [
    // English offensive words (expanded)
    'fuck', 'shit', 'bitch', 'asshole', 'damn', 'bastard', 'crap', 'dick', 'piss', 'cock',
    'pussy', 'slut', 'whore', 'bollocks', 'bugger', 'cunt', 'faggot', 'dyke', 'nigger', 'chink',
    'twat', 'wanker', 'prick', 'jerk', 'motherfucker', 'douche', 'slut',

    // Tagalog bad words (more added)
    'putangina', 'tangina', 'tanginamo', 'putang ina', 'gago', 'tarantado', 'peste', 'ulol',
    'tanga', 'bobo', 'loko', 'hayok', 'pekpek', 'kantot', 'puki', 'ulol', 'bastos', 'putang',
    'tang', 'pakshet', 'lokomoko', 'leche', 'gago ka', 'bobo ka', 'ulol ka', 'anak ng puta',
    'ulol ng utak', 'tarantado ka', 'tae ka', 'putang ina mo', 'pak ng ligo', 'tang ina mo',

    // Ilocano bad words
    'gaga', 'bobo', 'pakshet', 'ulol', 'tarantado', 'bulok', 'tonto', 'mangkukulam',

    // Cebuano / Bisaya offensive words
    'gago', 'buang', 'ulol', 'tarantado', 'peste', 'gubot', 'buwang', 'tonto', 'dautan',
    'bayot', 'tanga', 'gahi', 'putang ina', 'gibugto', 'loko', 'yawa', 'pakshet', 'putangina',

    // Hiligaynon bad words
    'ulol', 'gago', 'tonto', 'buwang', 'peste', 'bayot', 'tanga',

    // Other common Filipino slangs and phrases
    'anak ng puta', 'putang ina mo', 'lokomoko', 'ulol ka', 'bobo ka', 'gago ka', 'puta', 'gago',
    'ulol', 'gago ka', 'tae', 'bobo', 'peste',

    // Offensive slurs and derogatory terms
    'retard', 'cripple', 'idiot', 'moron', 'dumbass', 'loser', 'slut', 'whore', 'freak',

    // Misc vulgar words
    'sex', 'porno', 'fuckyou', 'motherfucker', 'asswipe', 'shitface', 'cum', 'jizz', 'twat',

];

echo json_encode($bannedWords);
