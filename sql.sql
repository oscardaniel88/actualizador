CREATE TABLE `properties` (
  `id` int(1) NOT NULL,
  `code` varchar(5) NOT NULL,
  `version` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `properties`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;