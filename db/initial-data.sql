-- Lectures '(2.+?) (\d\d:\d\d:00)' - '$1T$2+00:00'
insert into events values (nextval('seq_events'), 'МатСтат', '2022-12-12T13:30:00+00:00', '2022-12-12T15:00:00+00:00');
insert into tags values (nextval('seq_tags'), 'lecture');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'ПарПрог', '2022-12-12T17:00:00+00:00', '2022-12-12T18:30:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'МетодТранс', '2022-12-13T13:30:00+00:00', '2022-12-13T15:00:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'АнДан', '2022-12-13T15:20:00+00:00', '2022-12-13T16:50:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'ФП', '2022-12-16T11:40:00+00:00', '2022-12-16T13:30:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

-- Seminars
insert into events values (nextval('seq_events'), 'МатСтат', '2022-12-12T15:20:00+00:00', '2022-12-12T16:50:00+00:00');
insert into tags values (nextval('seq_tags'), 'seminar');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'АнДан', '2022-12-13T17:00:00+00:00', '2022-12-13T18:30:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'ИнЯз', '2022-12-16T13:30:00+00:00', '2022-12-16T15:00:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'ИнЯз', '2022-12-16T15:20:00+00:00', '2022-12-16T16:50:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));


-- Lectures
insert into events values (nextval('seq_events'), 'МатСтат', '2022-12-19T13:30:00+00:00', '2022-12-19T15:00:00+00:00');
insert into tags values (nextval('seq_tags'), 'lecture');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'ПарПрог', '2022-12-19T17:00:00+00:00', '2022-12-19T18:30:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'МетодТранс', '2022-12-20T13:30:00+00:00', '2022-12-20T15:00:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'АнДан', '2022-12-20T15:20:00+00:00', '2022-12-20T16:50:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'ФП', '2022-12-23T11:40:00+00:00', '2022-12-23T13:30:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

-- Seminars
insert into events values (nextval('seq_events'), 'МатСтат', '2022-12-19T15:20:00+00:00', '2022-12-19T16:50:00+00:00');
insert into tags values (nextval('seq_tags'), 'seminar');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'АнДан', '2022-12-20T17:00:00+00:00', '2022-12-20T18:30:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'ИнЯз', '2022-12-23T13:30:00+00:00', '2022-12-23T15:00:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'ИнЯз', '2022-12-23T15:20:00+00:00', '2022-12-23T16:50:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));


-- Lectures
insert into events values (nextval('seq_events'), 'МатСтат', '2022-12-26T13:30:00+00:00', '2022-12-26T15:00:00+00:00');
insert into tags values (nextval('seq_tags'), 'lecture');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'ПарПрог', '2022-12-26T17:00:00+00:00', '2022-12-26T18:30:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'МетодТранс', '2022-12-27T13:30:00+00:00', '2022-12-27T15:00:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'АнДан', '2022-12-27T15:20:00+00:00', '2022-12-27T16:50:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'ФП', '2022-12-30T11:40:00+00:00', '2022-12-30T13:30:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

-- Seminars
insert into events values (nextval('seq_events'), 'МатСтат', '2022-12-26T15:20:00+00:00', '2022-12-26T16:50:00+00:00');
insert into tags values (nextval('seq_tags'), 'seminar');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'АнДан', '2022-12-27T17:00:00+00:00', '2022-12-27T18:30:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'ИнЯз', '2022-12-30T13:30:00+00:00', '2022-12-30T15:00:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'ИнЯз', '2022-12-30T15:20:00+00:00', '2022-12-30T16:50:00+00:00');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));


insert into events values (nextval('seq_events'), 'Бадминтон', '2022-12-14T17:00:00+00:00', '2022-12-14T19:00:00+00:00');
insert into tags values (nextval('seq_tags'), 'sport');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));

insert into events values (nextval('seq_events'), 'Бадминтон', '2022-12-14T17:00:00+00:00', '2022-12-28T19:00:00+00:00');
insert into tags values (nextval('seq_tags'), 'sport');
insert into events_tags values (currval('seq_events'), currval('seq_tags'));