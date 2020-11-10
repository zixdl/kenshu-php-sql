USE kenshu_php_sql;

INSERT INTO users (user_name, email, address, user_password) VALUES 
    ('Song', 'song.tranvan@prtimes.co.jp', 'Vietnam', 'c53255317bb11707d0f614696b3ce6f221d0e2f2'),
    ('Duc', 'duc@gmail.com', 'Vietnam', 'c53255317bb11707d0f614696b3ce6f221d0e2f2'),
    ('Suzuki', 'suziki@gmail.com', 'Japan', 'c53255317bb11707d0f614696b3ce6f221d0e2f2'),
    ('Gaienmae', 'gaiemae@gmail.com', 'Japan', 'c53255317bb11707d0f614696b3ce6f221d0e2f2'),
    ('Hanzoumon', 'hanzoumon@gmail.com', 'Japan', 'c53255317bb11707d0f614696b3ce6f221d0e2f2'),
    ('Kudanshita', 'kudanshita@gmail.com', 'Japan', 'c53255317bb11707d0f614696b3ce6f221d0e2f2'),
    ('Kagurazaka', 'kagurazaka@gmail.com', 'Japan', 'c53255317bb11707d0f614696b3ce6f221d0e2f2');

INSERT INTO tags (tag_name) VALUES
    ('メディア'),
    ('エンタメ'),
    ('アプリ'),
    ('モバイル'),
    ('テクノロジー'),
    ('ビジネス');

INSERT INTO articles (title, content, author_id) VALUES
    ('送金アプリ「pring」、オリコと法人送金サービスで業務提携', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 1),
    ('アドベンチャーゲーム『Metamorphosis(メタモルフォーシス)』がPS4とNintendo Switchで発売！', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 2),
    ('★キャンプにおすすめ！★暗闇専用ボードゲーム『キャンパー＆ダンジョン』の先行予約を開始しました', 'Contrary to popular belief, Lorem Ipsum is not simply random text.', 3),
    ('ハッシュタグの数だけレゴが寄付される「#ハッピークリスマスをつなげよう #BuildtoGive」スタート', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 1),
    ('「靴下屋×OSAMU GOODS」コラボソックス　待望の第2弾発売！！', 'The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.', 4),
    ('コロナ禍で〝はたらくヒトを応援するマスク〟「BIZ MASK」シリーズ新発売！', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 2),
    ('Google Recommendations AI をイオングループ の ブランシェス株式会社が導入', 'It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.', 4),
    ('ブランドバッグシェア「ラクサス」が日本最大級の駅ビル「LUCUA」でバッグがその場で持って帰れるPOPUPストアを開催', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 1);

INSERT INTO article_tag (article_id, tag_id) VALUES
    (1,1),
    (1,2),
    (2,2),
    (2,3),
    (3,5),
    (4,2),
    (6,2),
    (6,1),
    (5,3);

INSERT INTO images(image, is_thumbnail, article_id) VALUES
    ('20201030055252neko.jpg', true, 1),
    ('20201030060541neko.jpg', false, 2),
    ('20201030055252neko.jpg', true, 2),
    ('20201030055268neko.jpg', true, 3),
    ('20201030055253neko.jpg', false, 3),
    ('20201030055221neko.jpg', false, 4),
    ('20201030055267neko.jpg', true, 4);
