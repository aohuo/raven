-- Run this once only when upgrading a database created from the old order.sql.
-- Back up the database first. New installations do not need this file.

ALTER TABLE `character_name`
  MODIFY `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  MODIFY `season_pass` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  ADD PRIMARY KEY (`name`);

ALTER TABLE `customer`
  MODIFY `cno` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  MODIFY `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  MODIFY `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  MODIFY `gno` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  MODIFY `buy` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  ADD PRIMARY KEY (`cno`);

ALTER TABLE `seller`
  ADD PRIMARY KEY (`call`);
