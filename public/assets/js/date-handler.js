const getTotalDuration = (start, end) => {
    const startDate  = moment(start);
    const endDate    = moment(end);
    const diffInDays = endDate.diff(startDate, "days");

    document.writeln(`${diffInDays} dag${diffInDays > 1 ? "en" : ""}`);
};
