CREATE TABLE `user` (
 `id` bigint NOT NULL AUTO_INCREMENT,
 `first_name` text NOT NULL,
 `last_name` text NOT NULL,
 `email` varchar(225) NOT NULL,
 `status` int NOT NULL DEFAULT '1',
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `password` varchar(225) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci

CREATE TABLE `user_events` (
 `evt_title` varchar(20) NOT NULL,
 `evt_place` varchar(20) NOT NULL,
 `event_id` bigint NOT NULL AUTO_INCREMENT,
 `user_id` bigint NOT NULL,
 `evt_start` datetime NOT NULL,
 `evt_end` datetime NOT NULL,
 `evt_text` text NOT NULL,
 `evt_color` varchar(7) NOT NULL,
 PRIMARY KEY (`event_id`),
 KEY `user_id` (`user_id`),
 CONSTRAINT `user_events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci
