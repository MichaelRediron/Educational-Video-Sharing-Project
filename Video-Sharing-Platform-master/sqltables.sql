    CREATE TABLE users (
    user_id INT(16) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    user_name VARCHAR(256) NOT NULL,
    user_type VARCHAR(256) NOT NULL,
    user_ranking DECIMAL(3,2) NOT NULL,
    user_password VARCHAR(256) NOT NULL
    );

    CREATE TABLE video (
    video_id INT(16) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    video_title VARCHAR(256) NOT NULL,
    video_topic VARCHAR(256) NOT NULL,
    video_path VARCHAR(256) NOT NULL,
    video_thumb VARCHAR(256) NOT NULL,
    video_rating DECIMAL(3,2) NOT NULL,
    video_views INT(16) NOT NULL
    video_pdate DATETIME NOT NULL,
    video_user VARCHAR(256), NOT NULL,
    user_id INT(16) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
    );

    CREATE TABLE tests (
    test_id INT(16) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    q_one VARCHAR(256) NOT NULL,
    q_two VARCHAR(256) NOT NULL,
    q_three VARCHAR(256) NOT NULL,
    q_four VARCHAR(256) NOT NULL,
    q_five VARCHAR(256) NOT NULL,
    a_one VARCHAR(256) NOT NULL,
    a_two VARCHAR(256) NOT NULL,
    a_three VARCHAR(256) NOT NULL,
    a_four VARCHAR(256) NOT NULL,
    a_five VARCHAR(256) NOT NULL,
    video_id INT(16) NOT NULL,
    FOREIGN KEY (video_id) REFERENCES video(video_id)
    );

    //if student wants to see score for each test (FEATURE implement if needed)
    CREATE TABLE testscore (
      score_id INT(16) AUTO_INCREMENT PRIMARY KEY NOT NULL,
      score DECIMAL(3,2) NOT NULL,
      user_id INT(16) NOT NULL,
      FOREIGN KEY (user_id) REFERENCES users(user_id),
      test_id INT(16) NOT NULL,
      FOREIGN KEY (test_id) REFERENCES tests(test_id),
    );

    CREATE TABLE request (
      request_id INT(16) AUTO_INCREMENT PRIMARY KEY NOT NULL,
      request_topic VARCHAR(256) NOT NULL,
      request_desc VARCHAR(256) NOT NULL,
      user_id INT(16) NOT NULL,
      FOREIGN KEY (user_id) REFERENCES users(user_id)
    );

    CREATE TABLE complete (
      complete_id INT(16) AUTO_INCREMENT PRIMARY KEY NOT NULL,
      video_id INT(16) NOT NULL,
      video_title VARCHAR(256) NOT NULL,
      request_topic VARCHAR(256) NOT NULL,
      request_desc VARCHAR(256) NOT NULL,
      noti_status VARCHAR(256) NOT NULL,
      request_id INT(16) NOT NULL,
      user_id INT(16) NOT NULL,
      FOREIGN KEY (user_id) REFERENCES users(user_id)
    );


