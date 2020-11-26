const timers = document.getElementsByClassName("countdownTimer");

const formatTimePart = (part) =>
  $.trim(part).length === 1 ? `0${part}` : part;

Array.from(timers).forEach((timer) => {
  const endTime = moment(timer.id).unix();
  const currTime = moment().unix();
  const diffTime = endTime - currTime;

  let duration = moment.duration(diffTime * 1000, "milliseconds");
  const interval = 500;

  setInterval(() => {
    if (duration > 0) {
      duration = moment.duration(
        duration.asMilliseconds() - interval,
        "milliseconds"
      );
      const diffDuration = moment.duration(duration);
      const d = formatTimePart(diffDuration.days()),
        h = formatTimePart(diffDuration.hours()),
        m = formatTimePart(diffDuration.minutes()),
        s = formatTimePart(diffDuration.seconds());
      timer.innerHTML = `${d}:${h}:${m}:${s}`;
    } else {
      timer.innerHTML = "Gesloten";
      timer.parentElement.classList.add("bg-dark");
    }
  }, interval);
});
