function storeVote($candidate_id, $user_id) {
    $vote = json_encode([
        'candidate_id' => $candidate_id,
        'timestamp' => time(),
        'user_id' => $user_id
    ]);
    
    $hashed_vote = hash('sha256', $vote); 
    $anonymized_token = bin2hex(random_bytes(16)); 
    
    $pdo = new PDO($dsn, $username, $password, $options);
    $stmt = $pdo->prepare("INSERT INTO votes (anonymized_token, hashed_vote, candidate_id) VALUES (?, ?, ?)");
    $stmt->execute([$anonymized_token, $hashed_vote, $candidate_id]);
}
